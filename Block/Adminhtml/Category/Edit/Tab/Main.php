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
namespace Lof\Faq\Block\Adminhtml\Category\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;

    /**
     * @var array
     */
    protected $_drawLevel;

    /**
     * @var \Lof\Faq\Model\ResourceModel\Category\Collection
     */
    protected $_categoryCollection;

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
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        \Lof\Faq\Model\ResourceModel\Category\Collection $categoryCollection,
        array $data = []
    ) {
        $this->pageLayoutBuilder   = $pageLayoutBuilder;
        $this->_systemStore        = $systemStore;
        $this->_wysiwygConfig      = $wysiwygConfig;
        $this->_categoryCollection = $categoryCollection;
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
        $model = $this->_coreRegistry->registry('faq_category');

        if ($this->_isAllowedAction('Lof_Faq::question_edit')) {
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

        if ($model->getCategoryId()) {
            $fieldset->addField('category_id', 'hidden', ['name' => 'category_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Title'), 'title' => __('Title'), 'required' => true, 'disabled' => $isElementDisabled]
        );

        $fieldset->addField(
            'identifier',
            'text',
            [
                'name' => 'identifier',
                'label' => __('URL Key'),
                'title'   => __('URL Key'),
                'class' => 'validate-identifier',
                'note' => __('Relative to Web Site Base URL'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $categories[] = ['label' => __('Please select'), 'value' => 0];

        $this->_drawLevel = $categories;

        $collection = $this->getCatCollection();
        $cats = [];
        foreach ($collection as $_cat) {
            if(!$_cat->getParentId()){
                $cat = [
                    'label' => $_cat->getTitle(),
                    'value' => $_cat->getId(),
                    'id' => $_cat->getId(),
                    'parent_id' => $_cat->getParentId(),
                    'level' => 0,
                    'postion' => $_cat->getCatPosition()
                ];
                $cats[] = $this->drawItems($collection, $cat);
            }
        }
        $this->drawSpaces($cats);

        if (count($this->_drawLevel)) {
            $fieldset->addField(
                'parent_id',
                'select',
                [
                    'name' => 'parent_id',
                    'label' => __('Parent Category'),
                    'title' => __('Parent Category'),
                    'values' => $this->_drawLevel,
                    'disabled' => $isElementDisabled
                ]
            );
        }

        $fieldset->addField(
            'page_layout',
            'select',
            [
                'name' => 'page_layout',
                'label' => __('Layout'),
                'values' => $this->pageLayoutBuilder->getPageLayoutsConfig()->toOptionArray(),
                'disabled' => $isElementDisabled
            ]
            );

        $fieldset->addField(
            'layout_type',
            'select',
            [
                'name' => 'layout_type',
                'label' => __('Template'),
                'options' => [
                    '1' => __('List'),
                    '2' => __('Grid')
                ],
                'disabled' => $isElementDisabled
            ]
            );

        $fieldset->addField(
            'grid_column',
            'select',
            [
                'name' => 'grid_column',
                'label' => __('Grid Column'),
                'options' => [
                    '1' => __('1'),
                    '2' => __('2'),
                    '3' => __('3'),
                    '4' => __('4')
                ],
                'disabled' => $isElementDisabled,
                'after_element_html' => '
                    <script>
                        require(["jquery"], function($){
                            $( document ).ready(function() {
                                $("#question_layout_type").on("change", function(){
                                    var val = $(this).val();
                                    if(val == 1){
                                        $("#question_grid_column").parents(".admin__field").hide();
                                    }else{
                                        $("#question_grid_column").parents(".admin__field").show();
                                    }
                                }).change();
                            });
                        });
                    </script>
                '
            ]
            );

        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
                'disabled' => $isElementDisabled
            ]
            );

        $fieldset->addField(
            'description',
            'editor',
            [
                'name'     => 'description',
                'label'    => __('Description'),
                'title'    => __('Description'),
                'style'    => 'height:20em',
                'config'   => $wysiwygConfig,
                'disabled' => $isElementDisabled
            ]
        );

        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'store_id',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true),
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
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'options' => [
                    '1' => __('Enabled'),
                    '0' => __('Disabled')
                ],
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'include_in_sidebar',
            'select',
            [
                'label' => __('Include the block FAQ Category on Sidebar'),
                'title' => __('Include the block FAQ Category on Sidebar'),
                'name' => 'include_in_sidebar',
                'options' => [
                    '1' => __('Yes'),
                    '0' => __('No')
                ],
                'disabled' => $isElementDisabled
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
            $model->setData('include_in_sidebar', '1');
            $model->setData('page_layout', '2columns-left');
        }
        $fieldset->addField(
            'position',
            'text',
            [
                'name'     => 'position',
                'label'    => __('Position'),
                'title'    => __('Position'),
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

    protected function _getSpaces($n)
    {
        $s = '';
        for($i = 0; $i < $n; $i++) {
            $s .= '--- ';
        }

        return $s;
    }

    public function drawItems($collection, $cat, $level = 0){
        foreach ($collection as $_cat) {
            if($_cat->getParentId() == $cat['id']){
                $cat1 = [
                    'label'     => $_cat->getTitle(),
                    'value'     => $_cat->getId(),
                    'id'        => $_cat->getId(),
                    'parent_id' => $_cat->getParentId(),
                    'level'     => 0,
                    'postion'   => $_cat->getCatPosition()
                ];
                $children[] = $this->drawItems($collection, $cat1, $level+1);
                $cat['children'] = $children;
            }
        }
        $cat['level'] = $level;
        return $cat;
    }

    public function drawSpaces($cats){
        if(is_array($cats)){
            foreach ($cats as $k => $v) {
                $v['label'] = $this->_getSpaces($v['level']) . $v['label'];
                $this->_drawLevel[] = $v;
                if(isset($v['children']) && $children = $v['children']){
                    $this->drawSpaces($children);
                }
            }
        }
    }

    public function getCatCollection(){
        $model = $this->_coreRegistry->registry('faq_category');
        $collection = $this->_categoryCollection;
        if ($model->getId()) {
            $collection->addFieldToFilter('category_id', array('neq' => $model->getId()));
        }
        $collection->setOrder('position');
        return $collection;
    }
}
