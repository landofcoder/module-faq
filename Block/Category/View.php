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

namespace Lof\Faq\Block\Category;

class View extends \Magento\Framework\View\Element\Template {
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Lof\Faq\Helper\Data
     */
    protected $_faqHelper;

    /**
     * @var \Lof\Faq\Model\Question
     */
    protected $_questionFactory;

    /**
     * @var \Lof\Faq\Model\Category
     */
    protected $_categoryFactory;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Question\Collection
     */
    protected $_collection;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Category\Collection
     */
    protected $_collectionCat;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * View constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Lof\Faq\Model\Question $questionFactory
     * @param \Lof\Faq\Model\Category $categoryFactory
     * @param \Lof\Faq\Model\ResourceModel\Category\CollectionFactory $collectionFactory
     * @param \Lof\Faq\Model\ResourceModel\Category\Collection $collectionCat
     * @param \Lof\Faq\Helper\Data $faqHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Lof\Faq\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        \Lof\Faq\Model\ResourceModel\Category\Collection $collectionCat,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_collectionCat = $collectionCat;
        $this->_collectionFactory = $collectionFactory;
        $this->_faqHelper = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource = $resource;
        parent::__construct($context);
    }

    public function _construct() {
        parent::_construct();
    }

    public function _toHtml() {
        if (!$this->getConfig('general_settings/enable')) {
            return;
        }
        return parent::_toHtml();
    }

    public function getConfig($key, $default = '') {
        if ($this->hasData($key)) {
            return $this->getData($key);
        }
        $result = $this->_faqHelper->getConfig($key);
        $c = explode("/", $key);
        if ($this->hasData($c[1])) {
            return $this->getData($c[1]);
        }
        if ($result == "") {
            $this->setData($c[1], $default);
            return $default;
        }
        $this->setData($c[1], $result);
        return $result;
    }

    public function getQuestionCategories() {
        $store = $this->_storeManager->getStore();
        $categoryCollection = $this->_categoryFactory->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addStoreFilter($store)
            ->setCurPage(1);
        $categoryCollection->getSelect()->order('position ASC');
        return $categoryCollection;
    }

    public function getBaseMediaUrl() {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    protected function _prepareLayout() {
        $cat = $this->getCategory();
        $page_title = $this->getConfig('faq_page/page_title');
        $meta_description = $cat->getMetaDescription();
        $meta_keywords = $cat->getMetaKeywords();
        if ($cat->getPageTitle()) $page_title = $cat->getPageTitle();

        $this->_addBreadcrumbs();
        $this->pageConfig->addBodyClass('faq-category' . $cat->getId());
        if ($page_title) {
            $this->pageConfig->getTitle()->set($page_title);
        }
        if ($meta_keywords) {
            $this->pageConfig->setKeywords($meta_keywords);
        }
        if ($meta_description) {
            $this->pageConfig->setDescription($meta_description);
        }
        return parent::_prepareLayout();
    }

    public function getCategory() {
        return $this->_coreRegistry->registry('current_faq_category');
    }

    protected function _addBreadcrumbs() {
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $route = $this->getConfig('general_settings/route');
        $page_title = $this->getConfig('faq_page/page_title');
        $show_breadcrumbs = $this->getConfig('category_page/show_breadcrumbs');
        $cat = $this->getCategory();

        if ($show_breadcrumbs && $breadcrumbsBlock) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $baseUrl
                ]
            );

            if ($route != '') {
                $breadcrumbsBlock->addCrumb(
                    'faq',
                    [
                        'label' => $page_title,
                        'title' => $page_title,
                        'link' => $this->getUrl('', array('_direct' => $route))
                    ]
                );
            }

            $breadcrumbsBlock->addCrumb(
                'faqcat',
                [
                    'label' => $cat->getTitle(),
                    'title' => $cat->getTitle(),
                    'link' => ''
                ]
            );
        }
    }

    protected function _beforeToHtml() {
        $postsBlock = $this->getLayout()->getBlock('faq.questions.list');
        $store = $this->_storeManager->getStore();
        $itemsperpage = (int)$this->getConfig('category_page/item_per_page');
        $cat = $this->getCategory();
        $layout = $cat->getData('layout_type');
        $isSearch = $this->getData('is_search');

        if ($this->getCollection()) {
            $questionCollection = $this->getCollection();
        } else {
            $questionCollection = $this->_questionFactory->getCollection()
                ->addFieldToFilter('is_active', 1);
            if (($layout == 1 || $layout == 2) && $itemsperpage) {
                $questionCollection->setPageSize($itemsperpage);
            }
            $questionCollection->addStoreFilter($store)
                ->setCurPage(1);

            $questionCollection->getSelect()
                ->joinLeft(
                    [
                        'cat' => $this->_resource->getTableName('lof_faq_question_category')],
                    'cat.question_id = main_table.question_id',
                    [
                        'question_id' => 'question_id',
                        'position' => 'position'
                    ]
                )
                ->where('cat.category_id = (?)', (int)$cat->getCategoryId());
            $questionCollection->getSelect()->order('position ASC')->order('main_table.question_id DESC')->group('main_table.question_id');
        }

        $this->setCollection($questionCollection);
        $toolbar = $this->getToolbarBlock();
        // set collection to toolbar and apply sort
        if (($layout == 1 || $layout == 2) && $toolbar && !$isSearch) {
            $toolbar->setData('_current_limit', $itemsperpage)->setCollection($questionCollection);
            $this->setChild('toolbar', $toolbar);
        }
        return parent::_beforeToHtml();
    }

    public function getCollection() {
        return $this->_collection;
    }

    public function setCollection($collection) {
        $this->_collection = $collection;
        return $this;
    }

    public function getToolbarBlock() {
        $block = $this->getLayout()->getBlock('faq_toolbar');
        if ($block) {
            return $block;
        }
    }

    public function getCollectionChildCategory($catId){
        $collectionChild = $this->_collectionFactory->create()->addFieldToFilter('parent_id',$catId);
        return $collectionChild;
    }

    public function getQuestionByCategory($catId){

        $productIds = $this->_collectionCat->getAllIds();
        $itemsperpage = (int)$this->getConfig('faq_page/item_per_page');
        $questionCollection = $this->_questionFactory->getCollection();
        if(!$productIds){
            $questionCollection->setPageSize($itemsperpage);
        }
        $questionCollection->addFieldToFilter('is_active',1);
        $questionCollection->getSelect()
            ->joinLeft(
                [
                    'cat' => $this->_resource->getTableName('lof_faq_question_category')],
                'cat.question_id = main_table.question_id',
                [
                    'question_id' => 'question_id',
                    'position' => 'position'
                ]
            );
        if($productIds){
            $questionCollection->addFieldToFilter('main_table.question_id', ['in'=>$productIds]);
        }
        $questionCollection->addFieldToFilter('cat.category_id', ['in'=>$catId]);


        $questionCollection->getSelect()->order('position ASC')->order('main_table.question_id DESC')->group('main_table.question_id');
        return $questionCollection;
    }


}
