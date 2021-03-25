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
namespace Lof\Faq\Model\ResourceModel\Tag;

use \Lof\Faq\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    
    protected function _construct()
    {
        $this->_init('Lof\Faq\Model\Tag', 'Lof\Faq\Model\ResourceModel\Tag');
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
       /** if (!$this->getFlag('store_filter_added')) {
        *    $this->performAddStoreFilter($store, $withAdmin);
        * }
        **/

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

        return $this;
    }

}
