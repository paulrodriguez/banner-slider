<?php

namespace AlphaTech\Slider\Controller\Adminhtml\Items;

class Index extends \Magento\Backend\App\Action
{

	const ADMIN_RESOURCE = 'AlphaTech_Slider::slide_items';

	protected $resultPageFactory = false;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('AlphaTech_Slider::slide_items');
            //->addBreadcrumb(__('CMS'), __('CMS'))
            //->addBreadcrumb(__('Static Blocks'), __('Static Blocks'));
        return $resultPage;
    }

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$this->initPage($resultPage)->getConfig()->getTitle()->prepend((__('Manage Slider Items')));

		return $resultPage;
	}
}
