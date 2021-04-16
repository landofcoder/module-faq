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

use Lof\Faq\Api\CategoriesInterface;
use Lof\Faq\Api\Data;
use Lof\Faq\Model\Category;
use Lof\Faq\Model\CategoryFactory;
use Lof\Faq\Model\ResourceModel\Category as ResourceCategory;
use Magento\Backend\Helper\Js;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

class Categories implements CategoriesInterface
{
    /**
     * @var ResourceConnection
     */
    protected $_resource;
    /**
     * @var CategoryFactory
     */
    protected $_categoryFactory;
    /**
     * @var Filesystem
     */
    protected $_filesystem;
    /**
     * @var Js
     */
    protected $jsHelper;
    /**
     * @var Category
     */
    protected $_category;
    /**
     * @var Data\CategorySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ResourceCategory
     */
    protected $resource;
    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourceCategory\CollectionFactory
     */
    private $categoryCollectionFactory;

    /**
     * Categories constructor.
     * @param ResourceConnection $resource
     * @param CategoryFactory $categoryFactory
     * @param Filesystem $filesystem
     * @param Js $jsHelper
     * @param Category $category
     * @param StoreManagerInterface $storeManager
     * @param Data\CategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceCategory $resourceCategory
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ResourceCategory\CollectionFactory $categoryCollection
     */
    public function __construct(
        ResourceConnection $resource,
        CategoryFactory $categoryFactory,
        Filesystem $filesystem,
        Js $jsHelper,
        Category $category,
        StoreManagerInterface $storeManager,
        Data\CategorySearchResultsInterfaceFactory $searchResultsFactory,
        ResourceCategory $resourceCategory,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        CollectionProcessorInterface $collectionProcessor,
        ResourceCategory\CollectionFactory $categoryCollection
    ) {
        $this->_resource = $resource;
        $this->_categoryFactory = $categoryFactory;
        $this->_filesystem = $filesystem;
        $this->jsHelper = $jsHelper;
        $this->_category = $category;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->storeManager = $storeManager;
        $this->resource = $resourceCategory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->categoryCollectionFactory = $categoryCollection;
    }

    /**
     * get list in backend
     *
     * @return Data\CategorySearchResultsInterface
     */
    public function getListInBackend()
    {
        $categoryCollection = $this->_category->getCollection()
            ->setCurPage(1)
            ->setOrder('category_id', 'DESC');

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($categoryCollection->getItems());
        $searchResults->setTotalCount($categoryCollection->getSize());
        return $searchResults;
    }

    /**
     * get list in frontend
     *
     * @return Data\CategorySearchResultsInterface
     */
    public function getListInFrontend()
    {
        $categoryCollection = $this->_category->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->setCurPage(1)
            ->setOrder('category_id', 'DESC');

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($categoryCollection->getItems());
        $searchResults->setTotalCount($categoryCollection->getSize());
        return $searchResults;
    }

    /**
     * @param Data\CategoryInterface $category
     * @return bool|Data\CategoryInterface
     * @throws CouldNotSaveException
     */
    public function save(\Lof\Faq\Api\Data\CategoryInterface $category)
    {
        if ($category['title'] && $category['identifier'] && $category['stores']) {
            try {
                $this->resource->save($category);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(
                    __('Could not save the category: %1', $exception->getMessage()),
                    $exception
                );
            }
            return $category;
        } else {
            return false;
        }
    }

    /**
     * @param int $categoryId
     * @return Data\CategoryInterface
     */
    public function getById($categoryId)
    {
        $category = $this->_categoryFactory->create()->load($categoryId);
        return $category->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria,
        $search
    ) {
        $collection = $this->categoryCollectionFactory->create();

        if ($search!="") {
            $collection->addFieldToFilter(
                'title',
                ['like' => '%'.$search.'%']
            );
        }
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\Faq\Api\Data\CategoryInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
