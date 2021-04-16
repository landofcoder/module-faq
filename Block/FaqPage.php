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
namespace Lof\Faq\Block;

class FaqPage extends \Magento\Framework\View\Element\Template
{

	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
	protected $_coreRegistry = null;

    /**
     * @var \Lof\Faq\Helper\Date
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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Framework\Registry
     * @param \Lof\Faq\Model\Question
     * @param \Lof\Faq\Model\Category
     * @param \Lof\Faq\Helper\Data
     * @param \Magento\Framework\App\ResourceConnection
     * @param array
     */
    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\Registry $registry,
    	\Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
        ) {
        $this->_faqHelper       = $faqHelper;
        $this->_coreRegistry    = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource        = $resource;
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
    	$baseUrl = $this->_storeManager->getStore()->getBaseUrl();
    	$page_title = $this->getConfig('faq_page/page_title');
        $show_breadcrumbs = $this->getConfig('faq_page/show_breadcrumbs');

        if($show_breadcrumbs && $breadcrumbsBlock){
        	$breadcrumbsBlock->addCrumb(
        		'home',
        		[
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link'  => $baseUrl
                ]
                );

        	$breadcrumbsBlock->addCrumb(
        		'faqpage',
        		[
                    'label' => $page_title,
                    'title' => $page_title,
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
        if(!$this->_collection) {
            $questionCollection = $this->_questionFactory->getCollection()
                    ->addFieldToFilter('is_active',1);
            $questionCollection->addStoreFilter($store)
                                ->setCurPage(1);
        } else {
            $questionCollection = $this->_collection;
        }
        if($itemsperpage ){
            $questionCollection->setPageSize($itemsperpage);
        }

        $questionCollection->getSelect()
            ->order("question_position ASC");

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
        $layout = $this->getConfig('faq_page/layout_type');
        $isSearch = $this->getData('is_search');
        if($layout==1 || $layout==2){
            if($this->getCollection()){
                $questionCollection = $this->getCollection();
            }else{
                $questionCollection = $this->_questionFactory->getCollection()
                ->addFieldToFilter('is_active',1);
                if($itemsperpage ){
                    $questionCollection->setPageSize($itemsperpage);
                }
                $questionCollection->addStoreFilter($store)
                ->setCurPage(1);
                $questionCollection->getSelect()
                ->order("question_position ASC");
            }
            $this->setCollection($questionCollection);
            $toolbar = $this->getToolbarBlock();
            // set collection to toolbar and apply sort
            if($toolbar && !$isSearch){
                $toolbar->setData('_current_limit',$itemsperpage)->setCollection($questionCollection);
                $this->setChild('toolbar', $toolbar);
            }
        }

        return parent::_beforeToHtml();
    }

    public function getQuestionByCategory($catId, $productIds = []){
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
        $questionCollection->getSelect()->where('cat.category_id = (?)', (int)$catId);
        $questionCollection->getSelect()->order('position ASC')->order('main_table.question_id DESC')->group('main_table.question_id');
        return $questionCollection;
    }

    public function getQuestionCategories(){
        $store = $this->_storeManager->getStore();
        $categoryCollection = $this->_categoryFactory->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addStoreFilter($store)
        ->setCurPage(1);
        $categoryCollection->getSelect()->order('position ASC');
        return $categoryCollection;
    }
}
