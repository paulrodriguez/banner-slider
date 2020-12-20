<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Test\Unit\Block;

use Magento\Framework\View\Element\Template\Context;
use AlphaTech\Slider\Model\ResourceModel\Slider\Item\CollectionFactory;
use AlphaTech\Slider\Model\ResourceModel\Slider\Item\Collection;
use AlphaTech\Slider\Model\Slider\ItemFactory;
use AlphaTech\Slider\Helper\Data;

class HomepageTest extends \PHPUnit\Framework\TestCase
{
	private $contextTemplateMock;
	private $resourceItemMock;
	private $itemMock;
	private $block;

	protected function setUp()
	{
		$this->contextTemplateMock = $this->createMock(Context::class);
        $this->helperDataMock = $this->createMock(Data::class);
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->itemFactoryMock = $this->createMock(ItemFactory::class);

        $this->collectionFactoryMock
        ->method('create')
        ->willReturn($this->collectionMock);

		$objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->block = $objectManager->getObject(
        	\NLA\Slider\Block\Homepage::class,
        	[
        		'context'=> $this->contextTemplateMock,
                'itemCollectionFactory'=>$this->collectionFactoryMock,
                'item_factory'=>$this->itemFactoryMock,
                'helper'=>$this->helperDataMock
        	]
    	);


	}

    public function testGetImages()
    {
        $data = [
            new \Magento\Framework\DataObject(['image'=>'test.jpg','link'=>'test.com','title'=>'t1']),
            new \Magento\Framework\DataObject(['image'=>'test2.jpg','link'=>'test2.com','title'=>'t2']),
        ];

        $iterator = new \ArrayIterator($data);
        $this->collectionMock
        ->method('addFieldToFilter')
        ->willReturnSelf();
        $this->collectionMock->expects($this->any())
        ->method('getIterator')->will($this->returnValue($iterator));

        $this->helperDataMock->expects($this->any())
        ->method('getImageUrl')
        ->will($this->returnValueMap(
            [
                ['test.jpg','test.com/images/test.jpg'],
                ['test2.jpg','test2.com/images/test2.jpg']
            ]
        ));

        $expected = [
            ['image_url'=>'test.com/images/test.jpg','link'=>'test.com','title'=>'t1'],
            ['image_url'=>'test2.com/images/test2.jpg','link'=>'test2.com','title'=>'t2']
        ];

        $this->assertEquals($expected,$this->block->getImages());
    }
}
