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
namespace Lof\Faq\Controller\Index;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Search extends \Magento\Framework\App\Action\Action
{
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
     * @param Context
     * @param \Magento\Store\Model\StoreManager
     * @param \Magento\Framework\View\Result\PageFactory
     * @param \Lof\Faq\Helper\Data
     * @param \Magento\Framework\View\Result\LayoutFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory
     * @param \Lof\Faq\Model\Question
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Lof\Faq\Model\Question $questionFactory
    ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->_faqHelper           = $faqHelper;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultLayoutFactory  = $resultLayoutFactory;
        $this->_questionFactory     = $questionFactory;
        $this->_storeManager        = $storeManager;
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
        $resultLayout = $this->resultLayoutFactory->create();
        $questionsBlock = $resultLayout->getLayout()->getBlock('loffaq.questions');

        $category_id = $this->getRequest()->getParam('catid');
        $s = $this->getRequest()->getParam('s');
        $s = strtolower($s);
        $store = $this->_storeManager->getStore();

        $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('is_active',1)
            ->addTagRelation();
        if($category_id) {
            $questionCollection->addCategoryFilter($category_id);
        }
        $questionCollection->addStoreFilter($store)
            ->setCurPage(1);
//        $questionCollection->getSelect()->where('(LOWER(title) LIKE "%' . addslashes($s) . '%") OR (LOWER(answer) LIKE "%' . addslashes($s) . '%") OR (LOWER(tag_table.name) LIKE "%' . addslashes($s) . '%") OR (LOWER(tag_table.alias) LIKE "%' . addslashes($s) . '%")')->order('question_position ASC');
        $questionCollection->addKeywordFilter($s)
            ->setOrder('question_position', 'ASC');

        $layout = $this->_faqHelper->getConfig("faq_page/layout_type");
        if($layout ==5){
            $questionsBlock->assign('layout', 1);
        }
        //echo $questionCollection->getSelect();
        $data['html'] = $questionsBlock->setData("is_search", true)->setCollection($questionCollection)->toHtml();
        $this->getResponse()->representJson(
            $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($data)
        );
    }

    public function getLayout() {
        return $this->_layout;
    }
}