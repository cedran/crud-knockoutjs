<?php
namespace Cedran\CrudKnockoutjs\Model;

use Cedran\CrudKnockoutjs\Api\Data\ItemInterface;
use Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface;
use Cedran\CrudKnockoutjs\Model\ResourceModel\Item as ResourceItem;
use Cedran\CrudKnockoutjs\Model\ItemFactory;
use Cedran\CrudKnockoutjs\Model\ResourceModel\Item\CollectionFactory as ItemCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsFactory;

class ItemRepository implements ItemRepositoryInterface
{
    protected $resource;
    protected $itemFactory;
    protected $itemCollectionFactory;
    protected $searchResultsFactory;

    public function __construct(
        ResourceItem $resource,
        ItemFactory $itemFactory,
        ItemCollectionFactory $itemCollectionFactory,
        SearchResultsFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->itemFactory = $itemFactory;
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function save(ItemInterface $item)
    {
        try {
            $this->resource->save($item);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save the item: %1', $exception->getMessage()),
                $exception
            );
        }
        return $item;
    }

    public function getById($itemId)
    {
        $item = $this->itemFactory->create();
        $this->resource->load($item, $itemId);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Item with id "%1" does not exist.', $itemId));
        }
        return $item;
    }

    public function delete(ItemInterface $item)
    {
        try {
            $this->resource->delete($item);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __('Could not delete the item: %1', $exception->getMessage()),
                $exception
            );
        }
        return true;
    }

    public function deleteById($itemId)
    {
        return $this->delete($this->getById($itemId));
    }

    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        $collection = $this->itemCollectionFactory->create();
        $collection->load();

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
