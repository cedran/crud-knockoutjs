<?php
namespace Cedran\CrudKnockoutjs\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface ItemRepositoryInterface
{
    public function save(\Cedran\CrudKnockoutjs\Api\Data\ItemInterface $item);
    public function getById($itemId);
    public function delete(\Cedran\CrudKnockoutjs\Api\Data\ItemInterface $item);
    public function deleteById($itemId);
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface;
}
