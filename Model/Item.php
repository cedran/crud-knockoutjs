<?php
namespace Cedran\CrudKnockoutjs\Model;

use Cedran\CrudKnockoutjs\Api\Data\ItemInterface;
use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel implements ItemInterface
{
    protected function _construct()
    {
        $this->_init(\Cedran\CrudKnockoutjs\Model\ResourceModel\Item::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData('entity_id');
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData('title', $title);
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }
}
