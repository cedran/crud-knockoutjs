<?php
namespace Cedran\CrudKnockoutjs\Block;

class Items extends \Magento\Framework\View\Element\Template
{
    protected $itemRepository;
    protected $searchCriteriaBuilder;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cedran\CrudKnockoutjs\Api\ItemRepositoryInterface $itemRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->itemRepository = $itemRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    public function getItems()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $items = $this->itemRepository->getList($searchCriteria)->getItems();
        return $items;
    }
}
