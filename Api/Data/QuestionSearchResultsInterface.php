<?php


namespace Lof\Faq\Api\Data;

interface QuestionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Question list.
     * @return \Lof\Faq\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Lof\Faq\Api\Data\QuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
