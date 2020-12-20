<?php
namespace NLA\Slider\Block;

use NLA\Slider\Model\ResourceModel\Slider\Item\CollectionFactory;

class Homepage extends \Magento\Framework\View\Element\Template
{
	protected $_images;
	protected $_item_factory;
	protected $_item;
	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
         CollectionFactory $itemCollectionFactory,
     	\NLA\Slider\Model\Slider\ItemFactory $item_factory,
        \NLA\Slider\Helper\Data $helper,
        array $data = []
    )
    {
        $this->helper = $helper;
        $this->item_collection = $itemCollectionFactory->create();
        $this->item_factory = $item_factory;

        parent::__construct($context, $data);
    }


    public function getImages()
    {

        $items = $this->item_collection->addFieldToFilter('is_enabled',array('eq'=>1));

        $res = [];

        foreach($items as $item)
        {
            $res[] = array('image_url'=>$this->helper->getImageUrl($item->getImage()),'link'=>$item->getLink(),'title'=>$item->getTitle());   
        }

        return $res;
    	
    }
}