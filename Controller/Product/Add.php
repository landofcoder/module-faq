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
namespace Lof\Faq\Controller\Product;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;

class Add extends \Magento\Framework\App\Action\Action
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
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;
    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */

    protected $resultForwardFactory;

    /**
     * @var \Lof\Faq\Model\Question
     */
    protected $_questionFactory;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;
    /**
     * @param Context
     * @param \Magento\Store\Model\StoreManager
     * @param \Magento\Framework\View\Result\PageFactory
     * @param \Lof\Faq\Helper\Data
     * @param \Magento\Framework\View\Result\LayoutFactory
     * @param \Magento\Framework\Translate\Inline\StateInterface   $inlineTranslation 
     * @param \Magento\Framework\Controller\Result\ForwardFactory
     * @param \Magento\Framework\View\LayoutInterface              $layout 
     * @param \Lof\Faq\Model\Question
      * @param \Magento\Framework\Mail\Template\TransportBuilder    $transportBuilder   
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\Faq\Helper\Data $faqHelper,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\View\LayoutInterface $layout,
        \Lof\Faq\Model\Question $questionFactory
        ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->_faqHelper           = $faqHelper;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultLayoutFactory  = $resultLayoutFactory;
        $this->_questionFactory     = $questionFactory;
        $this->_storeManager        = $storeManager;
        $this->_layout              = $layout;
        $this->inlineTranslation    = $inlineTranslation;
        $this->_transportBuilder    = $transportBuilder;
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
        $data = $this->getRequest()->getParams();

        // reCaptcha
        if(isset($data['g-recaptcha-response']) && ((int)$data['g-recaptcha-response']) === 0) {
            $this->messageManager->addError(__('Please check reCaptcha and try again.'));
            return;
        }
        if(isset($data['g-recaptcha-response'])){
            $captcha=$data['g-recaptcha-response'];
            $secretKey = $this->_faqHelper->getConfig('recaptcha_settings/privatekey');
            $ip = $_SERVER['REMOTE_ADDR']; 
            $params = array(
            'secret' => $secretKey,
            'response' => isset($captcha) ? $captcha : '',
            'remoteip' => $ip
            );
            $qs = http_build_query($params);
            $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?' . $qs); 
            $responseKeys = json_decode($response,true); 
            if(intval($responseKeys["success"]) !== 1) {
                $this->messageManager->addError(__('Please check reCaptcha and try again.'));            }
        }
        
        //Build email data object
        if(isset($data['categories'])) {
          $custom_form_data = array(
          ['label' => 'Name',
          'value' => $data['author_name']
          ],
          ['label' => 'Email',
          'value' => $data['author_email']
          ],
          ['label' => 'Category',
          'value' => $data['categories']
          ],
          ['label' => 'Message',
          'value' => $data['title']
          ]);
        }else {
           $custom_form_data = array(
          ['label' => 'Name',
          'value' => $data['author_name']
          ],
          ['label' => 'Email',
          'value' => $data['author_email']
          ],
          ['label' => 'Message',
          'value' => $data['title']
          ]);
        }
        $data['message'] = $this->_layout->createBlock('\Magento\Framework\View\Element\Template')
        ->setTemplate("Lof_Faq::email/items.phtml")
        ->setCustomFormData($custom_form_data)
        ->toHtml();
        
        $model = $this->_objectManager->create('Lof\Faq\Model\Question');
        $store = $this->_storeManager->getStore();
        $data['is_active'] = 0; 
        $data['stores'] = [$store->getId()];
        $data['question_products'][$data['product_id']] = ['position' => 0];
        if(isset($data['categories']))
        {
            $data['categories'] = [$data['categories']];
        }
        $model->setData($data);

        // try to save it
        try {
                // save the data
            $model->save();
                // display success message
            $this->messageManager->addSuccess(__('Your question has submitted sucessfully, we will answer that as soon as possible. Thanks you!'));

        } catch (\Exception $e) {
                // display error message
            $this->messageManager->addError($e->getMessage());
        }
         // SEND EMAIL
        $this->inlineTranslation->suspend();
        $enable_testmode = $this->_faqHelper->getConfig('email_settings/enable_testmode');
        if(!$enable_testmode && $this->_faqHelper->getConfig('email_settings/email_receive')!=''){
            $emails = $this->_faqHelper->getConfig('email_settings/email_receive');
            $emails = explode(',', $emails);
            foreach ($emails as $k => $v) {

                try {
                    $postObject = new \Magento\Framework\DataObject();
                    $data['title'] = __('Send Faq');
                    $postObject->setData($data);
                    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                    $transport = $this->_transportBuilder
                    ->setTemplateIdentifier($this->_faqHelper->getConfig('email_settings/email_template'))
                    ->setTemplateOptions(
                        [
                        'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                        ]
                        )
                    ->setTemplateVars(['data' => $postObject])
                    ->setFrom($this->_faqHelper->getConfig('email_settings/sender_email_identity'))
                    ->addTo($v)
                    ->setReplyTo($v)
                    ->getTransport();
                    try{
                        $transport->sendMessage();
                        $this->inlineTranslation->resume();
                    }catch(\Exception $e){
                        $error = true;
                        $this->messageManager->addError(
                            __('We can\'t process your request right now. Sorry, that\'s all we know.')
                            );
                    }
                } catch (\Exception $e) { 
                    $this->inlineTranslation->resume();
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                        );
                    return;
                }
            }
        }
        return;

    }
}