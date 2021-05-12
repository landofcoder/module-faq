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

namespace Lof\Faq\Api;

use Magento\Framework\Exception\LocalizedException;

interface CategoriesInterface
{
    /**
     * Get categories
     * @return \Lof\Faq\Api\Data\CategorySearchResultsInterface
     * @throws LocalizedException
     */
    public function getListInBackend();

    /**
     * Get categories
     * @return \Lof\Faq\Api\Data\CategorySearchResultsInterface
     * @throws LocalizedException
     */
    public function getListInFrontend();


    /**
     * @param \Lof\Faq\Api\Data\CategoryInterface $category
     * @return mixed
     */
    public function save(\Lof\Faq\Api\Data\CategoryInterface $category);

    /**
     * @param int $categoryId
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function getById($categoryId);


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param $search
     * @return \Lof\Faq\Api\Data\CategorySearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $search
    );
}
