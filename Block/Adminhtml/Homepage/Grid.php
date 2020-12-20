<?php
namespace AlphaTech\Slider\Block\Adminhtml\Homepage;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
	protected $_collectionFactory;
	protected $_item;

	protected $pageLayoutBuilder;


	public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \AlphaTech\Slider\Model\Slider\Item $item,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_item = $item;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        parent::__construct($context, $backendHelper, $data);
    }
}
