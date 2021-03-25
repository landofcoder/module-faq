<?php
namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\Data;
use Lof\Faq\Api\QuestionListByCategoryInterface;
use Lof\Faq\Model\QuestionFactory;

/**
 * Class QuestionByCategory
 * @package Lof\Faq\Model\Data
 */
class QuestionByCategory implements QuestionListByCategoryInterface
{
    /**
     * @var Data\QuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;

    /**
     * QuestionByCategory constructor.
     * @param QuestionFactory $questionFactory
     * @param Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory
     */
    public function __construct(
        QuestionFactory $questionFactory,
        Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory)
    {
        $this->_questionFactory = $questionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param $categoryId
     * @return Data\QuestionSearchResultsInterface|mixed
     */
    public function getQuestionByCategoryForApi($categoryId){
        $questionCollection = $this->_questionFactory->create()->getCollection();
        $questionCollection->addFieldToFilter('is_active',1);
        $questionCollection->addCategoryFilter($categoryId)
                            ->setOrder('position', 'ASC');
        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

}
