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
namespace Lof\Faq\Controller\Category;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Search extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Lof\Faq\Helper\Data
     */
    protected $_faqHelper;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Lof\Faq\Model\Question
     */
    protected $_questionFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context
     * @param \Magento\Store\Model\StoreManager
     * @param \Magento\Framework\View\Result\PageFactory
     * @param \Lof\Faq\Helper\Data
     * @param \Magento\Framework\View\Result\LayoutFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory
     * @param \Lof\Faq\Model\Question
     * @param \Lof\Faq\Model\Category
     * @param \Magento\Framework\App\ResourceConnection
     * @param \Magento\Framework\Registry
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Lof\Faq\Model\Question $questionFactory,
        \Lof\Faq\Model\Category $categoryFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\Registry $registry
        ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_faqHelper = $faqHelper;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->_questionFactory = $questionFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_storeManager = $storeManager;
        $this->_coreRegistry = $registry;
        $this->_resource = $resource;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {   
        if (!$this->getRequest()->isPost()) {
            throw new \Exception('Wrong request.');
        }
        $store = $this->_storeManager->getStore();
        $catId = $this->getRequest()->getParam('category_id');
        $cat = $this->_categoryFactory->getCollection()
        ->addFieldToFilter('is_active', array('eq' => 1))
        ->addFieldToFilter('main_table.category_id', array('eq' => (int)$catId))
        ->addStoreFilter($store)->getFirstItem();
        $this->_coreRegistry->register("current_faq_category", $cat);

        $resultLayout = $this->resultLayoutFactory->create();
        $questionsBlock = $resultLayout->getLayout()->getBlock('loffaq.questions');
        $s = $this->getRequest()->getParam('s');

        $questionCollection = $this->_questionFactory->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addStoreFilter($store)
        ->addTagRelation();

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
        ->where('(LOWER(main_table.title) LIKE "%' . addslashes($s) . '%") OR (LOWER(main_table.answer) LIKE "%' . addslashes($s) . '%") OR (LOWER(tag_table.name) LIKE "%' . addslashes($s) . '%") OR (LOWER(tag_table.alias) LIKE "%' . addslashes($s) . '%")')
        ->where('cat.category_id = (?)', (int)$cat->getCategoryId())
        ->order('position ASC')->group('main_table.question_id');


        $data['html'] = $questionsBlock->setData("is_search", true)->setCollection($questionCollection)->toHtml();
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($data)
            );
    }

    public function getLayout() {
        return $this->_layout;
    }
}
