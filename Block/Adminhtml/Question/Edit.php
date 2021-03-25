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
namespace Lof\Faq\Block\Adminhtml\Question;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context
     * @param \Magento\Framework\Registry
     * @param array
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
        ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'question_id';
        $this->_blockGroup = 'Lof_Faq';
        $this->_controller = 'adminhtml_question';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Question'));
        $this->buttonList->update('delete', 'label', __('Delete Question'));

        if ($this->_isAllowedAction('Lof_Faq::question_save')) {
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
                ],
                -100
                );
        }else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Lof_Faq::question_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Question'));
        } else {
            $this->buttonList->remove('delete');
        }

        $this->_formScripts[] = "
        function toggleEditor() {
            if (tinyMCE.getInstanceById('block_content') == null) {
                tinyMCE.execCommand('mceAddControl', false, 'block_content');
            } else {
                tinyMCE.execCommand('mceRemoveControl', false, 'block_content');
            }
        }
        require(['jquery','Lof_Faq/js/jquery.minicolors.min'], function($){
            $('input.minicolors').minicolors();
        });
        ";
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Get edit form container header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('faq_question')->getId()) {
            return __("Edit question '%1'", $this->escapeHtml($this->_coreRegistry->registry('faq_question')->getTitle()));
        } else {
            return __('New Question');
        }
    }
}
