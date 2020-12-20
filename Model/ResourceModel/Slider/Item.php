<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Model\ResourceModel\Slider;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\EntityManager;

class Item extends AbstractDb
{
	public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        EntityManager $entityManager,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
        $this->entityManager = $entityManager;
    }

	protected function _construct()
    {
        $this->_init('alphatech_slider_items', 'item_id');
    }
}
