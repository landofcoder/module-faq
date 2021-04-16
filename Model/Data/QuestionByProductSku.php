<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_Faq
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lof\Faq\Model\Data;
use Lof\Faq\Api\Data;
use Lof\Faq\Api\QuestionListByProductSkuInterface;
class QuestionByProductSku implements QuestionListByProductSkuInterface
{
    protected $productModelFactory;
    protected $searchResultsFactory;
    protected $_questionFactory;
    public function __construct(\Lof\Faq\Model\QuestionFactory $questionFactory,
                                \Magento\Catalog\Model\ProductFactory $productModelFactory,
                                Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory)
    {
        $this->_questionFactory = $questionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->productModelFactory = $productModelFactory;
    }

    /**
     * GET for questionList api by product sku
     * @param string $product_sku
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByProductSkuForApi($product_sku){
        $productModel = $this->productModelFactory->create();
        $productId = $productModel->getIdBySku($product_sku);

        $questionCollection = $this->_questionFactory->create()->getCollection()
            ->addFieldToFilter('is_active',1)
            ->addProductFilter($productId)
            ->setOrder('question_position', 'ASC');

        $questionCollection->getSelect()->group('main_table.question_id');

        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

}
