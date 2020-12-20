<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;

class Image extends Column {

	public function __construct(
		ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \AlphaTech\Slider\Helper\Data $helper,
        array $components = [],
        array $data = []
		)
	{
		$this->_helper = $helper;
		//$this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	public function prepareDataSource(array $dataSource)
	{
		//print_r($dataSource);
		if (isset($dataSource['data']['items'])) {
			$fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
            	if(isset($item['item_id'])) {
            		$item[$fieldName.'_src'] = $this->_helper->getImageUrl($item['image']);
            		$item[$fieldName.'_alt'] = $item['title'];
            		$item[$fieldName.'_orig_src'] = $this->_helper->getImageUrl($item['image']);
            		//$item[$fieldName.'_link']
            	}
            }
        }

        return $dataSource;
	}
}
