<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Test\Unit\Model\Slider;

use AlphaTech\Slider\Model\Slider\Item;

class ItemTest extends \PHPUnit\Framework\TestCase
{
	protected $model;

	protected function setUp()
	{
		$objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

		$this->model = $objectManager->getObject(Item::class);
	}

	public function testGetStatuses()
	{
		$this->assertSame([0=>'Disabled',1=>'Enabled'],$this->model->getStatuses());
	}

	public function testGetImageUrl()
	{
		$this->model->setData('image','testing.jpg');

		$this->assertEquals('pub/media/alphatech_slider/items/testing.jpg',$this->model->getImageUrl());
	}
}
