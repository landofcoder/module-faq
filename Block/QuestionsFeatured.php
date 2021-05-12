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

class QuestionsFeatured extends \Magento\Framework\View\Element\Template
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

    public function _toHtml(){
        if(!$this->getConfig('general_settings/enable')) return;
        return parent::_toHtml();
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

    protected function _beforeToHtml()
    {
        $store = $this->_storeManager->getStore();
        if($this->getCollection()){
            $questionCollection = $this->getCollection();
        }else{
            $numberFeaturedQuestions = $this->getConfig('faq_page/number_featured_questions');
            $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('is_active',1)
            ->addFieldToFilter('is_featured',1)
            ->addStoreFilter($store)->setCurPage(1);
            $questionCollection->getSelect()
            ->order("question_position ASC")
            ->limit($numberFeaturedQuestions);
        }
        $this->setCollection($questionCollection);
        return parent::_beforeToHtml();
    }

    public function getlatestFaq() {
        $numberLatestQuestions = $this->getConfig('faq_page/number_latest_questions');
        $store = $this->_storeManager->getStore();
        $questionCollection = $this->_questionFactory->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addStoreFilter($store)->setCurPage(1);
        $questionCollection->getSelect()
        ->order("creation_time ASC")
        ->limit($numberLatestQuestions);
        return $questionCollection;
    }
}
