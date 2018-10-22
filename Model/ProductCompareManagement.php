<?php


namespace M2express\ProductCompare\Model;

use M2express\ProductCompare\Api\ProductCompareManagementInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductCompareManagement implements ProductCompareManagementInterface
{
    protected $productCollectionFactory;
    protected $productRepository;
    protected $imgHelper;

    public function __construct(
        CollectionFactory $collectionFactory,
        ProductRepository $productRepository,
        Image $imgHelper
    ) {
        $this->productCollectionFactory = $collectionFactory;
        $this->imgHelper = $imgHelper;
        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductCompare($items)
    {

        $itemsArray = explode(',', $items);
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('entity_id', ['in'=>$itemsArray]);
        $productCollection->addAttributeToSelect('*');

        $returnData = [];

        foreach ($productCollection as $product) {
            $imgPath = $this->getImgPath($product->getData('entity_id'));
            $returnData[] = ['data' => $product->getData(), 'imgPath' => $imgPath ];
        }

        return $returnData;
    }

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

}
