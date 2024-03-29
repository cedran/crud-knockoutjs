<?php

namespace Cedran\CrudKnockoutjs\Controller\Item;

use Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class ItemList extends Action
{
    protected $jsonFactory;
    protected $itemRepository;
    protected $searchCriteriaBuilder;

    public function __construct(
        Context                 $context,
        JsonFactory             $jsonFactory,
        ItemRepositoryInterface $itemRepository,
        SearchCriteriaBuilder   $searchCriteriaBuilder
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->itemRepository = $itemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function execute()
    {
        $result = $this->jsonFactory->create();
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->itemRepository->getList($searchCriteria)->getItems();
        $itemsArray = [];

        foreach ($items as $item) {
            array_push($itemsArray, $item->getData());
        }

        return $result->setData(['items' => $itemsArray]);
    }
}
