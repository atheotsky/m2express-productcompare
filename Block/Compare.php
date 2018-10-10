<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\ProductCompare\Block;

class Compare extends \Magento\Catalog\Block\Product\ProductList\Item\Block
{
    public function getCompareHelper()
    {
        return $this->_compareProduct;
    }
}
