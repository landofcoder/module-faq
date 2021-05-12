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
namespace Lof\Faq\Block\Question;

class QuestionsRelated extends \Magento\Framework\View\Element\Template
{

	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
	protected $_coreRegistry = null;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $_faqHelper;

    /**
     * @var \Lof\Faq\Model\Question
     */
    protected $_questionFactory;
    protected $_questionsBlock;
    protected $_collection;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @param \Magento\Framework\View\Element\Template\Context
     * @param \Magento\Framework\Registry
     * @param \Lof\Faq\Model\Question
     * @param \Lof\Faq\Helper\Data
     * @param array
     */
    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\Registry $registry,
    	\Lof\Faq\Model\Question $questionFactory,
    	\Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
        ) {
        $this->_faqHelper   = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory  = $questionFactory;
        $this->_resource     = $resource;
        parent::__construct($context, $data);
    }

    public function getConfig($key, $default = '')
    {
        $c = explode("/", $key);
        if(count($c)==2){
            if($this->hasData($c[1])){
                return $this->getData($c[1]);
            }
        }
        if($this->hasData($key)){
            return $this->getData($key);
        }
        return $default;
    }

    public function _construct()
    {
    	parent::_construct();
    }

    public function _toHtml(){
        $question = $this->getQuestion();
        if(!$this->_faqHelper->getConfig('general_settings/enable') || !$question->getIsActive()) return;
        return parent::_toHtml();
    }

    public function getQuestion(){
        return $this->_coreRegistry->registry('current_faq_question');
    }


    /**
     * Set question collection
     * @param \Lof\Faq\Model\Question
     */
    public function setCollection($collection)
    {
    	$this->_collection = $collection;
    	return $this->_collection;
    }

    public function getCollection(){
    	return $this->_collection;
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $store = $this->_storeManager->getStore();
        $question = $this->getQuestion();
        $questionCollection = $this->_questionFactory->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addStoreFilter($store)
        ->setCurPage(1);
        $questionCollection->getSelect()
        ->joinLeft(
            [
            'relatedtbl' => $this->_resource->getTableName('lof_faq_question_relatedquestion')],
            'relatedtbl.relatedquestion_id = main_table.question_id',
            [
            'position' => 'position'
            ]
            )
        ->where('relatedtbl.question_id = (?)', $question->getId())
        ->group('main_table.question_id')
        ->order('position ASC');
        $this->setCollection($questionCollection);
        return parent::_beforeToHtml();
    }
}
