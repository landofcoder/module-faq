<?php


namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\Data;
use Lof\Faq\Api\QuestionListByTagInterface;

class QuestionByTag implements QuestionListByTagInterface
{
    protected $searchResultsFactory;
    protected $_questionFactory;
    public function __construct(\Lof\Faq\Model\Question $questionFactory,
                                Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory)
    {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->_questionFactory = $questionFactory;
    }
    /**
     * GET for questionList api by tag
     * @param string $tagCode
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByTagForApi($tagCode)
    {
        $tagCode = strtolower($tagCode);
        $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('is_active',1)
            ->addTagRelation()
            ->addTagFilter($tagCode)
            ->setOrder('question_position', 'ASC');

        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

}
