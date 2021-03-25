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
namespace Lof\Faq\Model\ResourceModel\Question;

use \Lof\Faq\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'question_id';

    protected $_flagStoreFilter = false;
    protected $_flagCategoryFilter = false;
    protected $_flagTagFilter = false;
    protected $_flagProductFilter = false;

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('lof_faq_question_store', 'question_id');

        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\Faq\Model\Question', 'Lof\Faq\Model\ResourceModel\Question');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }

    /**
     * Returns pairs question_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('question_id', 'title');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if(!$this->_flagStoreFilter) {
            $this->performAddStoreFilter($store, $withAdmin);

            if ($store instanceof \Magento\Store\Model\Store) {
                $store = [$store->getId()];
            }
            if (!is_array($store)) {
                $store = [$store];
            }
            $this->getSelect()->join(
                    ['store_table2' => $this->getTable('lof_faq_question_store')],
                    'main_table.question_id = store_table2.question_id',
                    []
                )->where('store_table2.store_id in (?,0)', $store)
                ->group(
                    'main_table.question_id'
                );
            $this->_flagStoreFilter = true;
        }
        return $this;
    }

    public function addCategoryFilter($category_id = null) {
        if($category_id && !$this->_flagCategoryFilter) {
            if(!is_array($category_id)) {
                $category_id = [$category_id];
            }
            $this->getSelect()->joinLeft(
                    ['cat' => $this->getTable('lof_faq_question_category')],
                    'main_table.question_id = cat.question_id',
                    ['question_id' => 'question_id','position' => 'position']
                )->where('cat.category_id in (?)', $category_id)
                ->group(
                    'main_table.question_id'
                );
            $this->_flagCategoryFilter = true;
        }
        return $this;
    }

    public function addTagRelation(){
        if(!$this->_flagTagFilter) {
            $this->getSelect()->joinLeft(
                    ['tag_table' => $this->getTable('lof_faq_question_tag')],
                    'main_table.question_id = tag_table.question_id',
                    ['tag_name' => 'name', 'tag_alias' => 'alias']
                )
                ->group(
                    'main_table.question_id'
                );
            $this->_flagTagFilter = true;
        }
        return $this;
    }

    public function addTagFilter($tag = ""){
        $this->addTagRelation();
        if($tag) {
            $tag = trim($tag);
            $tag = strtolower($tag);
            $this->getSelect()->where('(LOWER(tag_table.name) LIKE "%' . addslashes($tag) . '%") OR (LOWER(tag_table.alias) LIKE "%' . addslashes($tag) . '%")');
        }
        return $this;
    }

    public function addProductFilter($product_id = null) {
        if($product_id && !$this->_flagProductFilter) {
            if(!is_array($product_id)) {
                $product_id = [(int)$product_id];
            }
            $this->getSelect()->joinLeft(
                ['faqproduct' => $this->getTable('lof_faq_question_product')],
                'main_table.question_id = faqproduct.question_id',
                ['question_id' => 'question_id','position' => 'position']
            )->where('faqproduct.product_id in (?)', $product_id)
                ->group(
                    'main_table.question_id'
                );
            $this->_flagProductFilter = true;
        }
        return $this;
    }

    public function addKeywordFilter($keyWord = ""){
        if($keyWord) {
            $keyWord = trim($keyWord);
            $keyWord = strtolower($keyWord);
            $this->getSelect()->where('(LOWER(title) LIKE "%' . addslashes($keyWord) . '%") OR (LOWER(answer) LIKE "%' . addslashes($keyWord) . '%") OR (LOWER(tag_table.name) LIKE "%' . addslashes($keyWord) . '%") OR (LOWER(tag_table.alias) LIKE "%' . addslashes($keyWord) . '%")');
        }
        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('lof_faq_question_store', 'question_id');
    }

    
}