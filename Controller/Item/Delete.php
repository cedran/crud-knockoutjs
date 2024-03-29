<?php
namespace Cedran\CrudKnockoutjs\Controller\Item;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action
{
    protected $jsonFactory;
    protected $itemRepository;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ItemRepositoryInterface $itemRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->itemRepository = $itemRepository;
    }

    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        try {
            $itemId = $this->getRequest()->getParam('item_id');

            if (!$itemId) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Missing item ID.'));
            }

            $this->itemRepository->deleteById($itemId);

            $response = [
                'success' => true,
                'message' => __('Item deleted successfully.')
            ];
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => __('Error deleting item: %1', $e->getMessage())
            ];
        }

        return $resultJson->setData($response);
    }
}
