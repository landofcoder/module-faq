<?php
namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\Data;
class QuestionByCustomer implements \Lof\Faq\Api\QuestionListByCustomerInterface
{
    protected $_questionFactory;
    protected $customerRegistry;
    protected $searchResultsFactory;

    public function __construct(\Lof\Faq\Model\QuestionFactory $questionFactory,
                                \Magento\Customer\Model\CustomerRegistry $customerRegistry,
                                Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory)
    {
        $this->_questionFactory = $questionFactory;
        $this->customerRegistry = $customerRegistry;
        $this->searchResultsFactory = $searchResultsFactory;

    }

    /**
     * GET for questionList api by customer id
     * @param string $customerId
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByCustomerForApi($customerId){
        $customerModel = $this->customerRegistry->retrieve($customerId);
        $customerEmail = $customerModel->getDataModel()->getEmail();
        $questionCollection = $this->_questionFactory->create()->getCollection()
            ->addFieldToFilter('main_table.is_active',1)
            ->addFieldToFilter('author_email',$customerEmail);

        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($questionCollection->getItems());
        $searchResults->setTotalCount($questionCollection->getSize());
        return $searchResults;
    }

}
