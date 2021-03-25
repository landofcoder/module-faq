<?php


namespace Lof\Faq\Api\Data;

interface TagSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get tag list.
     * @return \Lof\Faq\Api\Data\TagInterface[]
     */
    public function getItems();

    /**
     * Set tag list.
     * @param \Lof\Faq\Api\Data\TagInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
