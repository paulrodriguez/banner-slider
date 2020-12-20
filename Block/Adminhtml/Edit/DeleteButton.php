<?php

namespace AlphaTech\Slider\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;


class DeleteButton implements ButtonProviderInterface
{
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    )
    {
        $this->context = $context;
        $this->registry = $registry;
        $this->urlBuilder = $context->getUrlBuilder();
    }
    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        $slider_item = $this->registry->registry('slider_item');
        $data = [];
        if ($slider_item->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl($slider_item->getId()) . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl($id)
    {

        return $this->context->getUrlBuilder()->getUrl('*/*/delete', ['id' => $id]);
    }
}
