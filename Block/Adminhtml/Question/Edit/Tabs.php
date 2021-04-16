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
namespace Lof\Faq\Block\Adminhtml\Question\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('question_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Question Information'));
    }

    protected function _prepareLayout()
    {
        $this->addTab(
                'general',
                [
                    'label' => __('General'),
                    'content' => $this->getLayout()->createBlock('Lof\Faq\Block\Adminhtml\Question\Edit\Tab\Main')->toHtml()
                ]
            );
        $this->addTab(
                'author',
                [
                    'label' => __('Author'),
                    'content' => $this->getLayout()->createBlock('Lof\Faq\Block\Adminhtml\Question\Edit\Tab\Author')->toHtml()
                ]
            );
        $this->addTab(
                'products',
                [
                    'label' => __('Products'),
                    'url' => $this->getUrl('loffaq/*/products', ['_current' => true]),
                    'class' => 'ajax'
                ]
            );
        $this->addTab(
                'relatedquestions',
                [
                    'label' => __('Related Questions'),
                    'url' => $this->getUrl('loffaq/*/relatedquestions', ['_current' => true]),
                    'class' => 'ajax'
                ]
            );
        $this->addTab(
                'design',
                [
                    'label' => __('Design'),
                    'content' => $this->getLayout()->createBlock('Lof\Faq\Block\Adminhtml\Question\Edit\Tab\Design')->toHtml()
                ]
            );
        $this->addTab(
                'meta',
                [
                    'label' => __('SEO'),
                    'content' => $this->getLayout()->createBlock('Lof\Faq\Block\Adminhtml\Question\Edit\Tab\Meta')->toHtml()
                ]
            );
    }
}
