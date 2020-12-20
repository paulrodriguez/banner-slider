<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Model\ResourceModel\Slider\Item;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected function _construct()
    {
        $this->_init(\AlphaTech\Slider\Model\Slider\Item::class,
					\AlphaTech\Slider\Model\ResourceModel\Slider\Item::class);

        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['item_id'] = 'main_table.item_id';
    }
}
