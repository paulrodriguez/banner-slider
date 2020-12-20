<?php

namespace NLA\Slider\Model\Slider;

use Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
	protected function _construct()
	{
		$this->_init(\NLA\Slider\Model\ResourceModel\Slider\Item::class);
	}

	public function getStatuses()
	{
		return [0=>'Disabled',1=>'Enabled'];
	}

	public function getEnabledItems() 
	{
		return $this->getCollection()->addFieldToFilter('is_enabled',array('eq'=>1));
	}

	public function getImageUrl()
	{
		return 'pub/media/nla_slider/items/'.$this->getData('image');
	}
}