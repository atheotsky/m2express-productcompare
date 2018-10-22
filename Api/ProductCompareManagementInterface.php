<?php

namespace M2express\ProductCompare\Api;

interface ProductCompareManagementInterface
{

    /**
     * GET for productCompare api
     * @param string $items
     * @return \ArrayObject
     */
    public function getProductCompare($items);
}