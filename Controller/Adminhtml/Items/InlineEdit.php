<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlphaTech\Slider\Controller\Adminhtml\Items;

use Magento\Backend\App\Action\Context;
//use Magento\Cms\Api\BlockRepositoryInterface as BlockRepository;
use Magento\Framework\Controller\Result\JsonFactory;
//use Magento\Cms\Api\Data\BlockInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'AlphaTech_Slider::item_save';

    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface
     */
    protected $itemFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param BlockRepository $blockRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        \AlphaTech\Slider\Model\Slider\ItemFactory $itemFactory,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->item_factory = $itemFactory;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = 'Please correct the data sent.';
                $error = true;
            } else {
                foreach (array_keys($postItems) as $item_id) {
                    $item = $this->item_factory->create();
                    $item->load($item_id);
                    if(!$item->getId()) {
                        $messages[] = 'Invalid Id: '.$item_id;
                        continue;
                    }

                    try {

                        $item->setData(array_merge($item->getData(), $postItems[$item_id]));
                        $item->save();
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithItemId(
                            $item,
                            $e->getMessage()
                        );
                        $error = false;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add block title to error message
     *
     * @param $item
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithItemId($item, $errorText)
    {
        return '[Item ID: ' . $item->getId() . '] ' . $errorText;
    }
}
