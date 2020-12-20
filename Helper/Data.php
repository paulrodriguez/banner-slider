<?php
/**
 * Copyright © Alpha Tech.
 * @author Paul Rodriguez
 */
namespace AlphaTech\Slider\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem\DirectoryList $dir,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {

        $this->_storeManager = $storeManager;
        $this->_dir = $dir;
        parent::__construct($context);
    }

    public function getImageUrl($image_name)
    {
			// @TODO remove 'pub' and use url for media folder
    	// return $this->_urlBuilder->getBaseUrl().'pub/media/alphatech_slider/items/'.$image_name;
			return $this->_storeManager->getStore()
				->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
					.'alphatech_slider/items/'.$image_name;
    }

    public function getItemStatuses()
    {
    	return [0=>'Disabled',1=>'Enabled'];
    }

    public function getImagePath($image_name)
    {
        return $this->_dir->getPath('media').DIRECTORY_SEPARATOR .'alphatech_slider'.DIRECTORY_SEPARATOR .'items'.DIRECTORY_SEPARATOR .$image_name;
    }
}
