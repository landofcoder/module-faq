<?php
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
