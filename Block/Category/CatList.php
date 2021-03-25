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
namespace Lof\Faq\Block\Category;

class CatList extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Lof\Faq\Helper\Category
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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Category\Collection
     */
    protected $_colleciton;

    /**
     * CatList constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Lof\Faq\Model\Question $questionFactory
     * @param \Lof\Faq\Model\Category $categoryFactory
     * @param \Lof\Faq\Model\ResourceModel\Category\Collection $collection
     * @param \Lof\Faq\Helper\Data $faqHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Lof\Faq\Model\ResourceModel\Category\Collection $collection,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
        ) {
        $this->_colleciton = $collection;
        $this->_faqHelper = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource = $resource;
        parent::__construct($context);
    }

    public function _toHtml(){
        if(!$this->_faqHelper->getConfig('general_settings/enable')) return;
        $store = $this->_storeManager->getStore();
        $collection = $this->_categoryFactory->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addFieldToFilter('include_in_sidebar',1)
        ->addStoreFilter($store)
        ->setCurPage(1);
        $collection->getSelect()->order('position ASC');
        $cats = [];
        $show_parent_category = $this->getData("show_parent");
        $show_parent_category = $show_parent_category?$show_parent_category:0;
        foreach ($collection as $_cat) {
            if($show_parent_category) {
                $cats[] = $this->drawItems($collection, $_cat);
            } else {
                if(!$_cat->getParentId()){
                    $cats[] = $this->drawItems($collection, $_cat);
                }
            }
        }
        $this->setCollection($cats);
        return parent::_toHtml();
    }

    public function drawItems($collection, $cat, $level = 0){
        foreach ($collection as $_cat) {
            if($_cat->getParentId() == $cat->getId()){
                $children[] = $this->drawItems($collection, $_cat, $level+1);
                $cat->setChildren($children);
            }
        }
        $cat->setSelevel($level);
        return $cat;
    }

    public function getCategoryHtml(){
        $collection = $this->getCollection();
        $html = $this->drawItem($collection, '');
        return $html;
    }

    public function drawItem($collection, $html = ''){
        foreach ($collection as $_cat) {

            $children = $_cat->getChildren();
            $class = '';
            if($children) $class = "class='level" . $_cat->getLevel() . "' parent";
            $html .= '<li ' . $class . ' >';
            $html .= '<a href="' . $this->_faqHelper->getCategoryUrl($_cat) .'">';
            if($_cat->getParentId() == 0){
            $html .= $_cat->getTitle() . '  ('.$this->getNumberQuestion($_cat->getId()).')';
            }else{
                $html .= $_cat->getTitle() . '  ('.$this->getNumberQuestionChild($_cat->getId()).')';
            }
            $html .= '</a>';
            if($children){
                $html .= '<span class="opener"><i class="fa fa-plus-square-o"></i></span>';
                $html .= '<ul class="level' . $_cat->getLevel() . ' children">';
                $html .= $this->drawItem($children);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
        return $html;
    }

    public function setCollection($collection){
        $this->_collection = $collection;
        return $this;
    }

    public function getCollection(){
        return $this->_collection;
    }

    public function getListIdCat($catId){
        $catChildId = '';
        $childs = $this->_colleciton->addFieldToFilter('parent_id',$catId);


        foreach ($childs  as $child){
            $catChildId .= $child->getId().",";
        }
        $catIds = $catId .",".$catChildId;
        return $catIds;
    }

    public function getNumberQuestion($catId){
            $question = $this->getQuestionByCategory($this->getListIdCat($catId), $this->_colleciton->getAllIds());
               return $question->getSize();

    }
    public function getNumberQuestionChild($catId){
        $question = $this->getQuestionByCategory($catId, $this->_colleciton->getAllIds());
        return $question->getSize();
    }

    public function getQuestionByCategory($catId, $productIds){


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