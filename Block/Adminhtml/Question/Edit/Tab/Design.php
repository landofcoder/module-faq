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
namespace Lof\Faq\Block\Adminhtml\Question\Edit\Tab;

class Design extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Lof\Faq\Model\Config\Source\AnimationType
     */
    protected $animate;
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Lof\Faq\Model\Config\Source\AnimationType $animate,
        array $data = []
    ) {
        $this->animate = $animate;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Lof_Faq::question_edit')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }
        
        $this->_eventManager->dispatch(
        'lof_check_license',
        ['obj' => $this,'ex'=>'Lof_Faq']
        );
       if (!$this->getData('is_valid') && !$this->getData('local_valid')) {
            $isElementDisabled = true;
            $wysiwygConfig['enabled'] = $wysiwygConfig['add_variables'] = $wysiwygConfig['add_widgets'] = $wysiwygConfig['add_images'] = 0;
            $wysiwygConfig['plugins'] = [];

        }
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('question_');

        $model = $this->_coreRegistry->registry('faq_question');

        $fieldset = $form->addFieldset(
            'general_fieldset',
            ['legend' => __('General Options'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'question_margin',
            'text',
            [
                'name'     => 'question_margin',
                'label'    => __('Margin Bottom (px)'),
                'title'    => __('Margin Bottom (px)'),
                'disabled' => $isElementDisabled
            ]
        );


        $fieldset = $form->addFieldset(
            'title_fieldset',
            ['legend' => __('Title Options'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'title_size',
            'text',
            [
                'name'     => 'title_size',
                'label'    => __('Font Size(px)'),
                'title'    => __('Font Size(px)'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'title_color',
            'text',
            [
                'name' => 'title_color',
                'label' => __('Text Color'),
                'title' => __('Text Color'),
                'disabled' => $isElementDisabled,
                'class' => 'minicolors'
            ]
        );

        $fieldset->addField(
            'title_color_active',
            'text',
            [
                'name'     => 'title_color_active',
                'label'    => __('Text Color (Active)'),
                'title'    => __('Text Color (Active)'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );

        $fieldset->addField(
            'title_bg',
            'text',
            [
                'name'     => 'title_bg',
                'label'    => __('Background'),
                'title'    => __('Background'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );

        $fieldset->addField(
            'title_bg_active',
            'text',
            [
                'name'     => 'title_bg_active',
                'label'    => __('Background (Active)'),
                'title'    => __('Background (Active)'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );
        $fieldset = $form->addFieldset(
            'titleborder_fieldset',
            [
                'legend' => __('Title Border Options'),
                'class'  => 'fieldset-wide'
            ]
        );

        $fieldset->addField(
            'border_width',
            'text',
            [
                'name'     => 'border_width',
                'label'    => __('Border Width(px)'),
                'title'    => __('Border Width(px)'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'title_border_color',
            'text',
            [
                'name'     => 'title_border_color',
                'label'    => __('Border Color'),
                'title'    => __('Border Color'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );

        $fieldset->addField(
            'title_border_radius',
            'text',
            [
                'name'     => 'title_border_radius',
                'label'    => __('Border Radius'),
                'title'    => __('Border Radius'),
                'note'     => __('Ex: 5px 5px 5px 5px'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset = $form->addFieldset(
            'question_fieldset',
            [
                'legend' => __('Icon Options'),
                'class'  => 'fieldset-wide'
            ]
        );

        $fieldset->addField(
            'question_icon',
            'text',
            [
                'name'     => 'question_icon',
                'label'    => __('Icon Class'),
                'title'    => __('Icon Class'),
                'note'     => __('For ex: <strong>fa-plus-square-o</strong>. Find more class at <a target="_blank" href="http://fontawesome.io/icons/">here</a>'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'question_active_icon',
            'text',
            [
                'name'     => 'question_active_icon',
                'label'    => __('Icon Class on Active'),
                'title'    => __('Icon Class on Active'),
                'note'     => __('For ex: <strong>fa-minus-square-o</strong>. Find more class at <a target="_blank" href="http://fontawesome.io/icons/">here</a>'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'animation_class',
            'select',
            [
                'name'     => 'animation_class',
                'label'    => __('Animation Type'),
                'values'   => $this->animate->toOptionArray(),
                'note'     => __('<a href="https://daneden.github.io/animate.css/" target="_blank">Check out all the animations here!</a>'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'animation_speed',
            'text',
            [
                'name'     => 'animation_speed',
                'label'    => __('Animation Speed(s)'),
                'title'    => __('Animation Speed(s)'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset = $form->addFieldset(
            'content_fieldset',
            [
                'legend' => __('Content Options'),
                'class'  => 'fieldset-wide'
            ]
        );

        $fieldset->addField(
            'body_size',
            'text',
            [
                'name'     => 'body_size',
                'label'    => __('Font Size (px)'),
                'title'    => __('Font Size (px)'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'body_color',
            'text',
            [
                'name'     => 'body_color',
                'label'    => __('Text Color'),
                'title'    => __('Text Color'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );

        $fieldset->addField(
            'body_bg',
            'text',
            [
                'name'     => 'body_bg',
                'label'    => __('Background Color'),
                'title'    => __('Background Color'),
                'disabled' => $isElementDisabled,
                'class'    => 'minicolors'
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('SEO');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('SEO');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
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
}
