<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\ProductCompare\Block;

use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\ObjectManagerInterface;

class Initialize extends \Magento\Framework\View\Element\Template
{
    protected $imageBuilder;
    protected $_objectManager;

    public function __construct(
        Context $context,
        ImageBuilder $imageBuilder,
        ObjectManagerInterface $objectManager
    ) {
        $this->imageBuilder = $imageBuilder;
        $this->_objectManager = $objectManager;
        parent::__construct($context);
    }

    public function getMediaPath()
    {
        $storeManager = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);
        $currentStore = $storeManager->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/product';
        return $mediaUrl;
    }
}
