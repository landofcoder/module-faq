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

use Lof\Faq\Api\Data\QuestionInterface;
use Lof\Faq\Api\Data\QuestionSearchResultsInterfaceFactory;
use Lof\Faq\Api\QuestionManagementInterface;
use Lof\Faq\Model\Category;
use Lof\Faq\Model\QuestionFactory;
use Lof\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Lof\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Backend\Helper\Js;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;

class Question implements QuestionManagementInterface
{
    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;
    /**
     * @var Js
     */
    protected $jsHelper;
    /**
     * @var ResourceQuestion
     */
    protected $resource;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var CollectionFactory
     */
    private $questionCollectionFactory;
    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var QuestionSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Question constructor.
     * @param QuestionFactory $questionFactory
     * @param Js $jsHelper
     * @param StoreManagerInterface $storeManager
     * @param ResourceQuestion $resource
     * @param CollectionFactory $questionCollectionFactory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param Category $category
     * @param ProductRepository $productRepository
     */
    public function __construct(
        QuestionFactory $questionFactory,
        Js $jsHelper,
        StoreManagerInterface $storeManager,
        ResourceQuestion $resource,
        CollectionFactory $questionCollectionFactory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        CollectionProcessorInterface $collectionProcessor,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        Category $category,
        ProductRepository $productRepository
    ) {
        $this->_questionFactory = $questionFactory;
        $this->jsHelper = $jsHelper;
        $this->storeManager = $storeManager;
        $this->resource = $resource;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->category = $category;
        $this->productRepository = $productRepository;
    }


    /**
     * @param QuestionInterface $question
     * @return bool|QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question)
    {
        if ($question['title'] && $question['categories'] && $question['stores']) {
            try {
                $this->resource->save($question);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(
                    __('Could not save the question: %1', $exception->getMessage()),
                    $exception
                );
            }
            return $question;
        } else {
            return false;
        }
    }


    /**
     * @param QuestionInterface $question
     * @return bool|QuestionInterface
     * @throws CouldNotSaveException
     */
    public function saveInFrontend(QuestionInterface $question)
    {
        if ($question['author_name'] && $question['title'] && $question['author_email'] && $question['stores']) {
            try {
                $this->resource->save($question);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(
                    __('Could not save the question: %1', $exception->getMessage()),
                    $exception
                );
            }
            return $question;
        } else {
            return false;
        }
    }

    /**
     * @param int $questionId
     * @return QuestionInterface
     */
    public function getById($questionId)
    {
        $question = $this->_questionFactory->create()->load($questionId);
        return $question->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria,
        $search,
        $tag,
        $identifier,
        $sku
    ) {
        $collection = $this->questionCollectionFactory->create();
        if ($tag) {
            $collection->addTagFilter($tag);
        }
        if ($identifier) {
            $category = $this->category->load($identifier, 'identifier');
            $categoryId = $category->getId();
            $collection->addCategoryFilter($categoryId);
        }
        if ($sku) {
            $product = $this->productRepository->get($sku);
            $collection->addProductFilter($product->getId());
        }
        if ($search != "") {
            $collection->addFieldToFilter(
                ['title', 'author_name', 'answer', 'tag'],
                [
                    ['like' => '%' . $search . '%'],
                    ['like' => '%' . $search . '%'],
                    ['like' => '%' . $search . '%'],
                    ['like' => '%' . $search . '%']
                ]
            );
        }
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\Faq\Api\Data\QuestionInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $model->load($model->getId());
            $items[] = $model->getData();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
