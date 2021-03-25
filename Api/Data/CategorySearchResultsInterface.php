<?php


namespace Lof\Faq\Api\Data;

interface CategorySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get category list.
     * @return \Lof\Faq\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * Set category list.
     * @param \Lof\Faq\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
