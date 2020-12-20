<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Test\Unit\Helper;



class DataTest extends \PHPUnit\Framework\TestCase
{
	protected $_helper;

	protected function setUp()
	{
		// mock classes
		$this->storeManagerMock = $this->getMockBuilder(\Magento\Store\Model\StoreManagerInterface::class)
            ->getMockForAbstractClass();

        $this->urlBuilderMock = $this->getMockBuilder(\Magento\Framework\UrlInterface::class)
            ->getMockForAbstractClass();

           $this->urlBuilderMock->expects($this->any())
            ->method('getBaseUrl')
            ->with([])
            ->willReturn('http://127.0.0.1:8882/nextlevelm2/');

        $this->directoryListMock = $this->getMockBuilder(\Magento\Framework\Filesystem\DirectoryList::class)->disableOriginalConstructor()
        	->setMethods(['getPath'])
        	->getMock();

        $this->directoryListMock->expects($this->any())
		->method('getPath')
		->with(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)
		->willReturn('/vagrant/httpdocs/nextlevem2/pub/media');


		 $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

		 $context = $objectManager->getObject(
            \Magento\Framework\App\Helper\Context::class,
            [
            	'urlBuilder'=>$this->urlBuilderMock
            ]
        );
		$this->_helper = $objectManager->getObject(\AlphaTech\Slider\Helper\Data::class,
			[
			'context'=>$context,
			'dir'=>$this->directoryListMock,
			'storeManager'=>$this->storeManagerMock,


			]
		);
	}

	public function testGetImageUrl()
	{
		$this->assertEquals('http://127.0.0.1:8882/nextlevelm2/pub/media/alphatech_slider/items/testing.jpg',$this->_helper->getImageUrl('testing.jpg'));
	}

	public function testGetStatuses()
	{
		$this->assertEquals([0=>'Disabled',1=>'Enabled'], $this->_helper->getItemStatuses());
	}

	public function testGetImagePath()
	{
		$this->assertEquals('/vagrant/httpdocs/nextlevem2/pub/media/alphatech_slider/items/testing.jpg',$this->_helper->getImagePath('testing.jpg'));
	}
}
