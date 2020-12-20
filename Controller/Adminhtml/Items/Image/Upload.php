<?php
namespace AlphaTech\Slider\Controller\Adminhtml\Items\Image;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Upload extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
	const ADMIN_RESOURCE = 'AlphaTech_Slider::item_save';

	protected $imageUploader;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Catalog\Model\ImageUploader $imageUploader
	)
	{
		$this->imageUploader = $imageUploader;
		parent::__construct($context);
	}



	public function execute()
	{
		$imageId = $this->_request->getParam('param_name', 'image');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
	}
}
