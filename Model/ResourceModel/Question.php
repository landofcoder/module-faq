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
namespace Lof\Faq\Model\ResourceModel;

class Question extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connectionName = null
        ) {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_faq_question', 'question_id');
    }

    /**
     * Process block data before deleting
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Cms\Model\ResourceModel\Page
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $condition = ['question_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_faq_question_store'), $condition);

        $condition = ['question_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_faq_question_product'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Perform operations after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        $table = $this->getTable('lof_faq_question_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = ['question_id = ?' => (int)$object->getId(), 'store_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {

                $data[] = ['question_id' => (int)$object->getId(), 'store_id' => (int)$storeId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }

        $insert = $delete = '';
        $oldCategories = $this->lookupCategoryIds($object->getId());
        $newCategories = (array)$object->getCategories();
        $table = $this->getTable('lof_faq_question_category');
        $insert = array_diff($newCategories, $oldCategories);
        $delete = array_diff($oldCategories, $newCategories);
        if ($delete) {
            $where = ['question_id = ?' => (int)$object->getId(), 'category_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                'question_id' => (int)$object->getId(),
                'category_id' => (int)$storeId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }


        // Question Product
        $table = $this->getTable('lof_faq_question_product');
        $where = ['question_id = ?' => (int)$object->getId()];
        if($questionProducts = $object->getData('question_products')){
            $this->getConnection()->delete($table, $where);
            $where = ['question_id = ?' => (int)$object->getId()];
            $this->getConnection()->delete($table, $where);
            $data = [];
            foreach ($questionProducts as $k => $_post) {
                $data[] = [
                'question_id' => (int)$object->getId(),
                'product_id' => $k,
                'position' => $_post['position']
                ];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
        
        // Question Related

        if($questionProducts = $object->getData('relatedquestions')){
            
            $table = $this->getTable('lof_faq_question_relatedquestion');
            $where = ['question_id = ?' => (int)$object->getId()];
            $this->getConnection()->delete($table, $where);
            if($questionProducts = $object->getData('relatedquestions')){
                $where = ['relatedquestion_id = ?' => (int)$object->getId()];
                $this->getConnection()->delete($table, $where);
                $data = [];
                foreach ($questionProducts as $k => $_post) {

                    $data[] = [
                    'question_id' => (int)$object->getId(),
                    'relatedquestion_id' => $k,
                    'position' => $_post['question_position']
                    ];
                }
                
                $this->getConnection()->insertMultiple($table, $data);
            }
        }

        if($tags = $object->getTag()){
                $tags = explode(",", $tags);
                if(!empty($tags)){
                    $table = $this->getTable('lof_faq_question_tag');
                    $where = ['question_id = ?' => (int)$object->getId()];
                    $this->getConnection()->delete($table, $where);
                    $data = [];
                    foreach ($tags as $k => $_tag) {
                        $name =  strtolower(str_replace(["_", " "], "-", trim($_tag) ) );
                        $data[] = [
                        'question_id' => (int)$object->getId(),
                        'alias' => $name,
                        'name' => $_tag
                        ];
                    }

                    $this->getConnection()->insertMultiple($table, $data);
                }
        }

        return parent::_afterSave($object);
    }

    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
            $object->setData('stores', $stores);
        }

        if ($object->getId()) {
            $categories = $this->lookupCategoryIds($object->getId());
            $object->setData('category_id', $categories);
            $object->setData('categories', $categories);
        }

        if ($id = $object->getId()) {
            $connection = $this->getConnection();
            $select = $connection->select()
            ->from($this->getTable('lof_faq_question_product'))
            ->where(
                'question_id = '.(int)$id
                );
            $products = $connection->fetchAll($select);
            $object->setData('question_products', $products);
        } 
        if ($id = $object->getId()) {
            $connection = $this->getConnection();
            $select = $connection->select()
            ->from($this->getTable('lof_faq_question_relatedquestion'))
            ->where(
                'question_id = '.(int)$id
                );
            $products = $connection->fetchAll($select);
            $object->setData('relatedquestions', $products);
        } 
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Lof\Faq\Model\Question $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $stores = [(int)$object->getStoreId(), \Magento\Store\Model\Store::DEFAULT_STORE_ID];

            $select->join(
                ['cbs' => $this->getTable('lof_faq_question_store')],
                $this->getMainTable() . '.question_id = cbs.question_id',
                ['store_id']
                )->where(
                'is_active = ?',
                1
                )->where(
                'cbs.store_id in (?)',
                $stores
                )->order(
                'store_id DESC'
                )->limit(
                1
                );
            }

            return $select;
        }

    /**
     * Check for unique of identifier of block to selected store(s).
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsUniqueBlockToStores(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($this->_storeManager->hasSingleStore()) {
            $stores = [\Magento\Store\Model\Store::DEFAULT_STORE_ID];
        } else {
            $stores = (array)$object->getData('stores');
        }

        $select = $this->getConnection()->select()->from(
            ['cb' => $this->getMainTable()]
            )->join(
            ['cbs' => $this->getTable('lof_faq_question_store')],
            'cb.question_id = cbs.question_id',
            []
            )->where(
            'cb.identifier = ?',
            $object->getData('identifier')
            )->where(
            'cbs.store_id IN (?)',
            $stores
            );

            if ($object->getId()) {
                $select->where('cb.question_id <> ?', $object->getId());
            }

            if ($this->getConnection()->fetchRow($select)) {
                return false;
            }

            return true;
        }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('lof_faq_question_store'),
            'store_id'
            )->where(
            'question_id = :question_id'
            );
            $binds = [':question_id' => (int)$id];
            return $connection->fetchCol($select, $binds);
        }

        public function lookupCategoryIds($id)
        {
            $connection = $this->getConnection();
            $select = $connection->select()->from(
                $this->getTable('lof_faq_question_category'),
                'category_id'
                )->where(
                'question_id = :question_id'
                );
                $binds = [':question_id' => (int)$id];
                return $connection->fetchCol($select, $binds);
            }
        }
