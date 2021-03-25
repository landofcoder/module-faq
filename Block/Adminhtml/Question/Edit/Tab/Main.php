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

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        \Lof\Faq\Model\Category $category,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('faq_question');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Lof_Faq::category_edit')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }
       $this->_eventManager->dispatch(
        'lof_check_license',
        ['obj' => $this,'ex'=>'Lof_Faq']
        );
       $wysiwygConfig = $this->_wysiwygConfig->getConfig();
       if (!$this->getData('is_valid') && !$this->getData('local_valid')) {
            $isElementDisabled = true;
            $wysiwygConfig['enabled'] = $wysiwygConfig['add_variables'] = $wysiwygConfig['add_widgets'] = $wysiwygConfig['add_images'] = 0;
            $wysiwygConfig['plugins'] = [];

        }
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('question_');

         $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getQuestionId()) {
            $fieldset->addField('question_id', 'hidden', ['name' => 'question_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name'     => 'title',
                'label'    => __('Question Title'),
                'title'    => __('Question Title'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $categoryCollection = $this->_category->getCollection();
        $categories = [];
        foreach ($categoryCollection as $k => $v) {
            $categories[] = [
                'label' => $v->getTitle(),
                'value'=> $v->getCategoryId()
            ];
        }

        $field = $fieldset->addField(
                'category_id',
                'multiselect',
                [
                    'name'     => 'categories[]',
                    'label'    => __('Category'),
                    'title'    => __('Category'),
                    'required' => true,
                    'values'   => $categories,
                    'disabled' => $isElementDisabled,
                    'style'    => 'width: 200px;'
                ]
            );
        $fieldset->addField(
            'tag',
            'text',
            [
                'name'     => 'tag',
                'label'    => __('Tags'),
                'title'    => __('Tags'),
                'note'     => __('Comma-separated.'),
                'disabled' => $isElementDisabled
            ]
        );
        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name'     => 'stores[]',
                    'label'    => __('Store View'),
                    'title'    => __('Store View'),
                    'required' => true,
                    'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
                    'disabled' => $isElementDisabled
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'store_id',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }

        $fieldset->addField(
            'answer',
            'editor',
            [
                'name'     => 'answer',
                'label'    => __('Answer'),
                'title'    => __('Answer'),
                'style'    => 'height:20em',
                'config'   => $wysiwygConfig,
                'disabled' => $isElementDisabled
            ]
        );

        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $fieldset->addField( 'creation_time', 
            'date', 
            [ 
                'label'       => __('Creation Time'),
                'title'       => __('Creation Time'),
                'name'        => 'creation_time',
                'date_format' => $dateFormat,
                'disabled'    => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'is_featured',
            'select',
            [
                'label'    => __('Is Featured'),
                'title'    => __('Is Featured'),
                'name'     => 'is_featured',
                'options'  => ['1' => __('Enabled'), '0' => __('Disabled')],
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label'    => __('Status'),
                'title'    => __('Status'),
                'name'     => 'is_active',
                'options'  => ['1' => __('Enabled'), '0' => __('Disabled')],
                'disabled' => $isElementDisabled
            ]
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField(
            'question_position',
            'text',
            [
                'name'     => 'question_position',
                'label'    => __('Position'),
                'title'    => __('Position'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'like',
            'text',
            [
                'name'     => 'like',
                'label'    => __('Like'),
                'title'    => __('Like'),
                'disabled' => $isElementDisabled
            ]
        );
        $fieldset->addField(
            'disklike',
            'text',
            [
                'name'     => 'disklike',
                'label'    => __('Dislike'),
                'title'    => __('Dislike'),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'question_url',
            'text',
            [
                'name'     => 'question_url',
                'label'    => __('Question URL'),
                'title'    => __('Question URL'),
                'disabled' => $isElementDisabled
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
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('General');
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
