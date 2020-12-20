<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace NLA\Slider\Model\Slider\Item;

use NLA\Slider\Model\ResourceModel\Slider\Item\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
    * @var 
    */
    //protected $fileInfo;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \NLA\Slider\Helper\Data $helper,
        Mime $mime,
        Filesystem $filesystem,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->helper = $helper;
        $this->collection = $blockCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->mime = $mime;
        $this->filesystem = $filesystem;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        

        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $file_name = $this->helper->getImagePath($item->getData('image'));
            $tmp = array(
                array(
                    'name'=>$item->getData('image'),
                    'url'=>$this->helper->getImageUrl($item->getData('image')),
                    'file'=>$file_name,
                    'type'=>$this->mime->getMimeType($file_name),
                    'size'=>filesize($file_name)

                )
            );

            $this->loadedData[$item->getId()]['image'] = $tmp;
        }

        //echo 'getting the data';
        $data = $this->dataPersistor->get('slider_item');
        if (!empty($data)) {
            
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            
            
            $this->loadedData[$item->getId()] = $item->getData();

            $this->dataPersistor->clear('slider_item');
        }
        //print_r($this->loadedData);
        return $this->loadedData;
    }
}
