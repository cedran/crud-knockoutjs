<?php
namespace Cedran\CrudKnockoutjs\Model\ResourceModel\Item;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Cedran\CrudKnockoutjs\Model\Item::class,
            \Cedran\CrudKnockoutjs\Model\ResourceModel\Item::class
        );
    }
}
