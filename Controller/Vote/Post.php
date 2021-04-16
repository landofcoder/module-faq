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
namespace Lof\Faq\Controller\Vote;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Post extends \Magento\Framework\App\Action\Action
{
    protected $_cacheTypeList;
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
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @param Context                                             $context
     * @param \Magento\Store\Model\StoreManager                   $storeManager
     * @param \Magento\Framework\View\Result\PageFactory          $resultPageFactory
     * @param \Lof\Faq\Helper\Data                               $faqHelper
     * @param \Lof\Faq\Model\Vote                               $vote
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Registry                         $registry
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        \Lof\Faq\Model\Question $question,
        \Lof\Faq\Model\Vote $vote,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession
        ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->_faqHelper           = $faqHelper;
        $this->_question            = $question;
        $this->_vote                = $vote;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $params = $this->_request->getPostValue();
        if(!empty($params)){
            $voteCollection = $this->_vote->getCollection();
            $disllike = $like = 0;
            if($params['like'] == 1){
                $like = 1;
                $disllike = 0;
            }else{
                $like = 0;
                $disllike = 1;
            }
            $customer = $this->_customerSession->getCustomer();
            $data = [
            'ip'             => $this->getUserIP(),
            'customer_email' => $customer->getName(),
            'customer_name'  => $customer->getEmail(),
            'like'           => $like,
            'disllike'       => $disllike,
            'question_id'        => $params['questionId']
            ];
            $collection = $voteCollection->addFieldToFilter('ip', $this->getUserIP())
            ->addFieldToFilter('question_id', $params['questionId']);
            $vote = $this->_vote->load($this->getUserIP(), 'ip');
            $question = $this->_question->load($params['questionId']);
            $questionData = $responseData = [];

            if(empty($collection->getData())){
                $like = (int)$question->getLike() + $like;
                $disllike = (int)$question->getDisklike() + $disllike;
                $question->setLike($like);
                $question->setDisklike($disllike);
                $responseData['like'] = $like;
                $responseData['disklike'] = $disllike;
                try{
                    $message = __('Thanks for your vote!');
                    $status = 1;
                    $vote->setData($data)->save();
                    $question->save();
                    $this->_cacheTypeList->cleanType('full_page');
                }catch(\Exception $e){
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                        );
                    return;
                }

            }else{
                $status = 0;
                $message = __('Already voted!');
            }
            $responseData['message'] = $message;
            $responseData['status'] = $status;
            $this->getResponse()->representJson(
                $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
                );
            return;
        }
    }
    public function getUserIP()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        return $ip;
    }



}
