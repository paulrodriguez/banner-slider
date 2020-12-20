<?php
namespace NLA\Slider\Model\Slider\Item\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsEnabled implements OptionSourceInterface
{
	public function __construct(\NLA\Slider\Helper\Data $helper)
	{
		$this->_helper = $helper;
	}

	public function toOptionArray()
    {
        $availableOptions = $this->_helper->getItemStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}