<?php


namespace Lof\Faq\Api;

use Lof\Faq\Api\Data\CategoryInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface CategoriesInterface
 * @package Lof\Faq\Api
 */
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
     * @param CategoryInterface $category
     * @return mixed
     */
    public function save(CategoryInterface $category);

    /**
     * @param int $categoryId
     * @return CategoryInterface
     */
    public function getById($categoryId);

}
