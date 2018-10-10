<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\ProductCompare\Block;

use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Framework\View\Element\Template\Context;

class Initialize extends \Magento\Framework\View\Element\Template
{
    protected $imageBuilder;

    public function __construct(Context $context, ImageBuilder $imageBuilder)
    {
        $this->imageBuilder = $imageBuilder;
        parent::__construct($context);
    }
}
