<?php

namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\CategoriesInterface;
use Lof\Faq\Api\Data;
use Lof\Faq\Model\Category;
use Lof\Faq\Model\CategoryFactory;
use Lof\Faq\Model\ResourceModel\Category as ResourceCategory;
use Magento\Backend\Helper\Js;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Categories
 * @package Lof\Faq\Model\Data
 */
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
     * Categories constructor.
     * @param ResourceConnection $resource
     * @param CategoryFactory $categoryFactory
     * @param Filesystem $filesystem
     * @param Js $jsHelper
     * @param Category $category
     * @param StoreManagerInterface $storeManager
     * @param Data\CategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param ResourceCategory $resourceCategory
     */
    public function __construct(
        ResourceConnection $resource,
        CategoryFactory $categoryFactory,
        Filesystem $filesystem,
        Js $jsHelper,
        Category $category,
        StoreManagerInterface $storeManager,
        Data\CategorySearchResultsInterfaceFactory $searchResultsFactory,
        ResourceCategory $resourceCategory)

    {
        $this->_resource = $resource;
        $this->_categoryFactory = $categoryFactory;
        $this->_filesystem = $filesystem;
        $this->jsHelper = $jsHelper;
        $this->_category = $category;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->storeManager = $storeManager;
        $this->resource = $resourceCategory;
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
     * @param string $fieldId
     * @return string|void
     */
    public function uploadImage($fieldId = 'image')
    {

        if (isset($_FILES[$fieldId]) && $_FILES[$fieldId]['name'] != '') {
            $uploader = $this->_objectManager->create(
                'Magento\Framework\File\Uploader',
                ['fileId' => $fieldId]
            );

            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/faq/';
            try {
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($mediaDirectory->getAbsolutePath($mediaFolder)
                );
                return $mediaFolder . $result['name'];
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                $this->messageManager->addError($e->getMessage());
            }
        }
        return;
    }

}
