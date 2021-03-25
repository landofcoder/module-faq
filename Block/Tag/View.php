<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_FAQ
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\Faq\Block\Tag;

class View extends \Magento\Framework\View\Element\Template
{

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
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Framework\Registry
     * @param \Lof\Faq\Model\Question
     * @param \Lof\Faq\Model\Category
     * @param \Lof\Faq\Helper\Data
     * @param array
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        array $data = []
        ) {
        $this->_faqHelper = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context);
    }

    public function getConfig($key, $default = '')
    {
        if($this->hasData($key)){
            return $this->getData($key);
        }
        $result = $this->_faqHelper->getConfig($key);
        $c = explode("/", $key);
        if($this->hasData($c[1])){
            return $this->getData($c[1]);
        }
        if($result == ""){
            $this->setData($c[1], $default);
            return $default;
        }
        $this->setData($c[1], $result);
        return $result;
    }

    public function _construct()
    {
        parent::_construct();
    }

    public function _toHtml(){
        if(!$this->getConfig('general_settings/enable')){
            return;
        }
        return parent::_toHtml();
    }

    protected function _addBreadcrumbs()
    {
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs'); 
        $route = $this->_faqHelper->getConfig('general_settings/route');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $page_title = $this->getConfig('faq_page/page_title');
        $show_breadcrumbs = $this->getConfig('faq_page/show_breadcrumbs');
        $tagName = $this->getRequest()->getParam('tag_name');

        if($show_breadcrumbs && $breadcrumbsBlock){
           $breadcrumbsBlock->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link'  => $baseUrl
            ]
            );

           if($route!=''){
            $breadcrumbsBlock->addCrumb(
              'faq',
              [
                  'label' => $page_title,
                  'title' => $page_title,
                  'link'  => $this->getUrl('', array('_direct'=>$route))
              ]
              );
        }
        $breadcrumbsBlock->addCrumb(
            'tag',
            [
                'label' => __('Tag: %1', $tagName),
                'title' => __('Tag: %1', $tagName),
                'link'  => ''
            ]
            );
    }
}

    /**
     * @param $collection
     * @return $this
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }

    public function getCollection(){
        $store = $this->_storeManager->getStore();
        $itemsperpage = (int)$this->getConfig('faq_page/item_per_page');
        $isSearch = $this->getData('is_search');
        $questionIds = $this->_coreRegistry->registry('questionIds');
        $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('main_table.is_active',1)
            ->setPageSize($itemsperpage)
            ->addStoreFilter($store)
            ->setCurPage(1);
        $questionCollection->getSelect()
            ->where('main_table.question_id in (?)', $questionIds)
            ->order("main_table.question_id ASC");
        $this->setCollection($questionCollection);

        $this->setCollection($questionCollection);
        $toolbar = $this->getToolbarBlock();

        // set collection to toolbar and apply sort
        if($toolbar && !$isSearch){
            $toolbar->setData('_current_limit',$itemsperpage)->setCollection($questionCollection);
            $this->setChild('toolbar', $toolbar);
        }

        return $questionCollection;
    }

    protected function _prepareLayout()
    {   
        $page_title = $this->getConfig('faq_page/page_title');
        $meta_description = $this->getConfig('faq_page/meta_description');
        $meta_keywords = $this->getConfig('faq_page/meta_keywords');

        $this->_addBreadcrumbs();
        $this->pageConfig->addBodyClass('faq-page');
        if($page_title){
            $this->pageConfig->getTitle()->set($page_title);   
        }
        if($meta_keywords){
            $this->pageConfig->setKeywords($meta_keywords);   
        }
        if($meta_description){
            $this->pageConfig->setDescription($meta_description);   
        }
        return parent::_prepareLayout();
    }

    public function getToolbarBlock()
    {
        $block = $this->getLayout()->getBlock('faq_toolbar');
        if ($block) {
            return $block;
        }
    }

    protected function _beforeToHtml()
    {
        $store = $this->_storeManager->getStore();
        $itemsperpage = (int)$this->getConfig('faq_page/item_per_page'); 
        $isSearch = $this->getData('is_search'); 
        $questionIds = $this->_coreRegistry->registry('questionIds');
        $questionCollection = $this->_questionFactory->getCollection()
        ->addFieldToFilter('main_table.is_active',1)
        ->setPageSize($itemsperpage)
        ->addStoreFilter($store)
        ->setCurPage(1);
        $questionCollection->getSelect()
        ->where('main_table.question_id in (?)', $questionIds)
        ->order("main_table.question_id ASC");
        $this->setCollection($questionCollection);

        $this->setCollection($questionCollection);
        $toolbar = $this->getToolbarBlock();

        // set collection to toolbar and apply sort
        if($toolbar && !$isSearch){
            $toolbar->setData('_current_limit',$itemsperpage)->setCollection($questionCollection);
            $this->setChild('toolbar', $toolbar);
        }
        return parent::_beforeToHtml();
    }
 
    public function getNameTag(){
        return $this->_coreRegistry->registry('tag_name');
    }
}