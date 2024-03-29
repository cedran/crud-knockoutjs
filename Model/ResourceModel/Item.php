<?php
namespace Cedran\CrudKnockoutjs\Model\ResourceModel;

class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('cedran_crudknockoutjs_item', 'entity_id');
    }
}
