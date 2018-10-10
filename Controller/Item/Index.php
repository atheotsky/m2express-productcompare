<?php
/**
 * Copyright © Magento2Express. All rights reserved.
 * @author: <mailto:contact@magento2express.com>.
 */

namespace M2express\ProductCompare\Controller\Item;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Json\Helper\Data;
use Magento\Catalog\Helper\Image;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $productCollectionFactory;
    protected $productRepository;
    protected $_storeManager;
    protected $storeManager;
    protected $jsonHelper;
    protected $imgHelper;
    protected $items;

    /**
     * Index constructor.
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param ProductRepository $productRepository
     * @param Data $jsonHelper
     * @param Image $imgHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        ProductRepository $productRepository,
        Data $jsonHelper,
        Image $imgHelper,
        array $data = []
    ) {
        parent::__construct($context);
        $this->jsonHelper = $jsonHelper;
        $this->imgHelper = $imgHelper;
        $this->productRepository = $productRepository;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $items = $this->getRequest()->getParam('items');
        $returnData = [];
        if ($items) {
            $items = explode(',', $items);
            $productCollection = $this->getProductCollection($items);

            foreach ($productCollection as $product) {
                $imgPath = $this->getImgPath($product->getData('entity_id'));
                $returnData[] = ['data' => $product->getData(), 'imgPath' => $imgPath ];
            }

            $this->jsonResponse($returnData);
        }
    }

    /**
     * @param $productId
     * @return string
     */
    public function getImgPath($productId)
    {
        try {
            $product = $this->productRepository->getById($productId);
            //product_base_image
            $image = $this->imgHelper->init($product, 'product_thumbnail_image');
            return $image->getUrl();
        } catch (NoSuchEntityException $e) {
            return '';
        }
    }

    /**
     * @param $itemsArray
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection($itemsArray)
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToFilter('entity_id', ['in'=>$itemsArray]);
        $collection->addAttributeToSelect('*');

        return $collection;
    }

    /**
     * @param string $response
     * @return mixed
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
