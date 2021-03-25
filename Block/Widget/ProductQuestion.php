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
namespace Lof\Faq\Block\Widget;

class ProductQuestion extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Framework\Registry
     * @param \Lof\Faq\Model\Question
     * @param \Lof\Faq\Model\Category
     * @param \Magento\Framework\App\ResourceConnection
     * @param \Lof\Faq\Helper\Data
     * @param array
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Lof\Faq\Helper\Data $faqHelper,
        array $data = []
        ) {
        $this->_faqHelper = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource = $resource;
        parent::__construct($context);
        $this->setTemplate("Lof_Faq::widget/product_question.phtml");
    }

    public function getConfig($key)
    {
        $result = $this->_faqHelper->getConfig($key);
        return $result;
    }

    public function _construct()
    {
        parent::_construct();
    }

    public function _toHtml(){
        if($this->getConfig('general_settings/enable')){
            return parent::_toHtml();
        }
        return;
    }

    /**
     * @param \Lof\Faq\Model\Question\ResourceModel\Collection
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }

    public function getCollection(){
        return $this->_collection;
    }

    public function getToolbarBlock()
    {
        if($this->getData("show_pagging")){
            $block = $this->getLayout()->getBlock('faq_toolbar');
            if(!$block) {
                $block = $block->getLayout()->createBlock('Lof\Faq\Block\Toolbar', "faq_toolbar")->setTemplate("Lof_Faq::toolbar.phtml");
                $childBlock = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager',"faq_toolbar_pager");
                $block->addChild($childBlock);
                if ($block) {
                    return $block;
                }
            }
        }
        return;
    }

    public function getProduct(){
        return $this->_coreRegistry->registry('current_product');
    }

    protected function _beforeToHtml()
    {
        $store = $this->_storeManager->getStore();
        $itemsperpage = (int)$this->getData('item_per_page');
        $itemsperpage = $itemsperpage?$itemsperpage:1;
        $layout = $this->getData('layout_type');
        $isSearch = $this->getData('is_search');

        $product = $this->getProduct();

        if($this->getCollection()){
            $questionCollection = $this->getCollection();
        }else{
            $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('is_active',1);
            if(($layout==1 || $layout==2) && $itemsperpage ){
                $questionCollection->setPageSize($itemsperpage);
            }
            $questionCollection->addStoreFilter($store)
            ->setCurPage(1);
            
            $questionCollection->getSelect()
            ->joinLeft(
                [
                    'question_product' => $this->_resource->getTableName('lof_faq_question_product')],
                    'question_product.question_id = main_table.question_id',
                [
                    'question_id' => 'question_id',
                    'position' => 'position'
                ]
                )
            ->where('question_product.product_id = (?)', (int)$product->getId());
            $questionCollection->getSelect()->order('position ASC')->group('main_table.question_id');
        }

        $this->setCollection($questionCollection);
        $toolbar = $this->getToolbarBlock();
        // set collection to toolbar and apply sort
        if(($layout==1 || $layout==2) && $toolbar && !$isSearch && $itemsperpage){
            $toolbar->setData('_current_limit',$itemsperpage)->setCollection($questionCollection);
            $this->setChild('toolbar', $toolbar);
        }
        return parent::_beforeToHtml();
    }

    public function getQuestionCategories(){
        $enable_categories = $this->getData('enable_categories');
        $catIds = null;
        if($enable_categories && $this->getData('popup_categories')){
            $catIds = explode(',', $this->getData('popup_categories'));
        }
        $store = $this->_storeManager->getStore();
        $categoryCollection = $this->_categoryFactory->getCollection()
        ->addFieldToFilter('is_active',1);
        if($catIds){
            $categoryCollection->addFieldToFilter('main_table.category_id', ['in' => $catIds]);
        }
        $categoryCollection->addStoreFilter($store)
        ->setCurPage(1);
        $categoryCollection->getSelect()->order('position ASC');
        return $categoryCollection;
    }
}