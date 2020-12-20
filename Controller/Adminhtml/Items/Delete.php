<?php

namespace AlphaTech\Slider\Controller\Adminhtml\Items;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
	const ADMIN_RESOURCE = 'AlphaTech_Slider::item_delete';

	public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AlphaTech\Slider\Model\Slider\ItemFactory $itemFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_itemFactory = $itemFactory;
        parent::__construct($context);
    }

    public function execute()
    {
    	$id = $this->getRequest()->getParam('id');

    	$resultRedirect = $this->resultRedirectFactory->create();

    	if($id)
    	{
    		$item = $this->_itemFactory->create();
    		$item->load($id);

    		if($item->getId())
    		{
    			try {
    				$item->delete();

    				$this->messageManager->addSuccessMessage(__('The item has been deleted.'));
    				return $resultRedirect->setPath('*/*');
    			} catch(Exception $e) {
    				$this->messageManager->addErrorMessage($e->getMessage());
                	// go back to edit form
                	return $resultRedirect->setPath('*/*/edit', ['item_id' => $id]);
    			}
    		}

    		$this->messageManager->addErrorMessage(__('Invalid id'));
    		return $resultRedirect->setPath('*/*/');
    	}

    	$this->messageManager->addErrorMessage(__('Invalid id'));
    	return $resultRedirect->setPath('*/*/');
    }
}
