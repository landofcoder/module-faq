<?php

namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\Data;
use Lof\Faq\Api\QuestionRepositoryInterface;
use Lof\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    protected $_questionFactory;
    protected $searchResultsFactory;

    public function __construct(\Lof\Faq\Model\Question $questionFactory,
                                QuestionCollectionFactory $questionCollectionFactory,
                                Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory,
                                Data\QuestionInterfaceFactory $dataQuestionFactory,
                                CollectionProcessorInterface $collectionProcessor = null
    )
    {
        $this->_questionFactory = $questionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataPageFactory = $dataQuestionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * GET for questionList api by title,answer,tag
     * @param string $keyWord
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListByKeyword($keyWord)
    {
        $keyWord = strtolower($keyWord);
        $questionCollection = $this->_questionFactory->getCollection()
            ->addFieldToFilter('is_active', 1)
            ->addTagRelation();
        $questionCollection->addKeywordFilter($keyWord)
            ->setOrder('question_position', 'ASC');

        /** @var Data\PageSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList()
    {
        $questionCollection = $this->_questionFactory->getCollection()
        ->setCurPage(1)
        ->setOrder('question_id', 'DESC');

        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

    /**
     * Retrieve collection processor
     *
     * @return CollectionProcessorInterface
     * @deprecated 102.0.0
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Lof\Faq\Model\Api\SearchCriteria\QuestionCollectionProcessor'
            );
        }
        return $this->collectionProcessor;
    }

}
