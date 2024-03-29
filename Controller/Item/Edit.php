<?php
namespace Cedran\CrudKnockoutjs\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface;
use Cedran\CrudKnockoutjs\Api\Data\ItemInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;

class Edit extends Action
{
    protected $jsonFactory;
    protected $itemRepository;
    protected $itemFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ItemRepositoryInterface $itemRepository,
        ItemInterfaceFactory $itemFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->itemRepository = $itemRepository;
        $this->itemFactory = $itemFactory;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        try {
            $data = $this->getRequest()->getPostValue();

            if (empty($data['item_id'])) {
                throw new LocalizedException(__('Missing item ID.'));
            }

            $item = $this->itemRepository->getById($data['item_id']);

            // Atualize o item com os dados recebidos
            if (isset($data['title'])) {
                $item->setTitle($data['title']);
            }
            if (isset($data['description'])) {
                $item->setDescription($data['description']);
            }

            // Salva as alterações no item
            $this->itemRepository->save($item);

            $response = [
                'success' => true,
                'message' => __('Item updated successfully.'),
                'item' => $item->getData()
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Error updating item: %1', $e->getMessage())
            ];
        }

        return $resultJson->setData($response);
    }
}
