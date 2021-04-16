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
namespace Lof\Faq\Block\Widget;

class Faq extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var \Lof\Faq\Helper\Data
     */
    protected $_faqHelper;

    /**
     * @var \Lof\Faq\Model\Question
     */
    protected $_questionFactory;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Question\Collection
     */
    protected $_collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Category\Collection
     */
    protected $_collectionCat;

    /**
     * Faq constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Lof\Faq\Model\ResourceModel\Category\Collection $collectionCat
     * @param \Lof\Faq\Model\Question $questionFactory
     * @param \Lof\Faq\Helper\Data $faqHelper
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\Registry $registry,
        \Lof\Faq\Model\ResourceModel\Category\Collection $collectionCat,
    	\Lof\Faq\Model\Question $questionFactory,
    	\Lof\Faq\Helper\Data $faqHelper,
      \Magento\Framework\App\ResourceConnection $resource,
      array $data = []
      ) {
        $this->_collectionCat = $collectionCat;
    	$this->_faqHelper = $faqHelper;
    	$this->_questionFactory = $questionFactory;
      $this->_resource = $resource;
      parent::__construct($context);
      $this->setTemplate("Lof_Faq::widget/list.phtml");
    }

    public function _toHtml(){
    	if(!$this->_faqHelper->getConfig('general_settings/enable')) return;
    	$store = $this->_storeManager->getStore();
    	$itemsperpage = (int)$this->getData('item_per_page');
      $categories = $this->getData('categories');
      $cats = explode(',', $categories);

      $questionCollection = $this->_questionFactory->getCollection()
      ->addFieldToFilter('main_table.is_active',1);

      if($this->getData('is_featured')){
        $questionCollection->addFieldToFilter('main_table.is_featured',1);
      }

      if($itemsperpage ) $questionCollection->setPageSize($itemsperpage);
      $questionCollection->addStoreFilter($store);
      if(count($cats)>0){
        $questionCollection->getSelect("main_table.question_id")
        ->joinLeft([
          'cat' => $this->_resource->getTableName('lof_faq_question_category')],
          'cat.question_id = main_table.question_id',[
          "question_id" => "question_id"
          ])->where('cat.category_id IN (?)', $categories);
        if(count($cats)==1){
          $questionCollection->getSelect()->order('position ASC');
        } else {
          $questionCollection->getSelect()->order("main_table.question_id DESC");
        }
        $questionCollection->getSelect()->group('cat.question_id');
      }
      $this->setCollection($questionCollection);

      return parent::_toHtml();
    }

    public function setCollection($collection)
    {
    	$this->_collection = $collection;
    	return $this;
    }

    public function getCollection(){
    	return $this->_collection;
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
          $productIds = !is_array($productIds)?$productIds:implode(",",$productIds);
          $questionCollection->getSelect()->where('main_table.question_id IN (?)', $productIds);
        }
        $questionCollection->getSelect()->where('cat.category_id IN (?)', $catId);


        $questionCollection->getSelect()->order('position ASC')->order('main_table.question_id DESC')->group('main_table.question_id');
        return $questionCollection;
    }
  }
