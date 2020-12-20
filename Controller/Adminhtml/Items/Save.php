<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlphaTech\Slider\Controller\Adminhtml\Items;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save CMS page action.
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
	const ADMIN_RESOURCE = 'AlphaTech_Slider::item_save';

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\AlphaTech\Slider\Model\Slider\ItemFactory $item_factory,
		\Magento\Catalog\Model\ImageUploader $imageUploader
	)
	{
		$this->context = $context;
		$this->item_factory = $item_factory;
		$this->imageUploader = $imageUploader;
		parent::__construct($context);
	}

	public function getId()
	{
		$id = (int)$this->getRequest()->getParam('id',false);

		return (int)$id ?: $this->getRequest()->getParam('item_id',false);
	}

	public function execute()
	{
		$resultRedirect = $this->resultRedirectFactory->create();

		$item = $this->item_factory->create();

		$post_data = $this->getRequest()->getPostValue();

		$id = $this->getId();
		if($id) {
			$item->load($id);
			if(!$item) {
				$this->messageManager->addErrorMessage(__('Invalid slider item'));
				$resultRedirect->setPath('*/*/index');
			}
		}


		$item->setData('is_enabled',$post_data['is_enabled']);
		$item->setData('title',$post_data['title']);
		$item->setData('sort_order',$post_data['sort_order']);
		$item->setData('store_id',$post_data['store_id']);
		$item->setData('link',$post_data['link']);
		if(isset($post_data['image']) && is_array($post_data['image'])) {
			$item->setData('image',$this->processImages($post_data['image']));
		}

		try {
			$item->save();

			$this->messageManager->addSuccessMessage(__('slider item saved'));

			if(isset($post_data['back'])) {
				if($post_data['back'] == 'continue') {
					return $resultRedirect->setPath('*/*/edit', ['id' => $item->getId()]);
				}
			}
		} catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
        }

        return $resultRedirect->setPath('*/*/index');
	}

	public function processImages($images)
	{
		$image_name = '';
		//print_r($images);
		//exit();
		foreach($images as $image)
		{
			if(isset($image['tmp_name'])) {
				$image_name = $this->imageUploader->moveFileFromTmp($image['name']);
			} else {
				$image_name = $image['name'];
			}
		}

		return $image_name;
	}
}
