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
        $this->_faqHelper = $faqHelper;
        $this->_coreRegistry = $registry;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource = $resource;
        parent::__construct($context);
    }

    protected function _addBreadcrumbs()
    {
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        $route = $this->_faqHelper->getConfig('general_settings/route');
        $page_title = $this->_faqHelper->getConfig('faq_page/page_title');
        $question = $this->getQuestion();
        if($breadcrumbsBlock){
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
                'faqcat',
                [
                    'label' => $question->getTitle(),
                    'title' => $question->getTitle(),
                    'link'  => ''
                ]
                );
        }
    }

    public function getBaseMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getQuestionCategory($catId){
        $store = $this->_storeManager->getStore();
        $cat = $this->_categoryFactory->getCollection()
        ->addFieldToFilter('is_active', array('eq' => 1))
        ->addFieldToFilter('main_table.category_id', array('eq' => $catId))
        ->addStoreFilter($store)->getFirstItem();
        return $cat;
    }

    protected function _prepareLayout()
    {
        $question = $this->getQuestion();
        $page_title = $this->getConfig('faq_page/page_title');
        $meta_description = $question->getMetaDescription();
        $meta_keywords = $question->getMetaKeywords();
        if($question->getPageTitle()!='') $page_title = $question->getPageTitle();
        $this->_addBreadcrumbs();
        $this->pageConfig->addBodyClass('faq-question'.$question->getId());
        if(!$page_title) $page_title = $question->getTitle();
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

    public function getQuestion(){
        return $this->_coreRegistry->registry('current_faq_question');
    }
}
