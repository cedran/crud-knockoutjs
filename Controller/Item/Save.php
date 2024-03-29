<?php
namespace Cedran\CrudKnockoutjs\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface;
use Cedran\CrudKnockoutjs\Api\Data\ItemInterfaceFactory;

class Save extends Action
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

            // Se um ID de item é fornecido, carrega o item existente, caso contrário, cria um novo.
            if (!empty($data['item_id'])) {
                $item = $this->itemRepository->getById($data['item_id']);
            } else {
                $item = $this->itemFactory->create();
            }

            // Configura os dados do item.
            $item->setTitle($data['title']);
            $item->setDescription($data['description']);

            // Salva o item.
            $this->itemRepository->save($item);

            $response = [
                'success' => true,
                'message' => __('Item saved successfully.'),
                'item' => $item->getData()
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Error saving item: %1', $e->getMessage())
            ];
        }

        return $resultJson->setData($response);
    }
}
