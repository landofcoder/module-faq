<?php


namespace Lof\Faq\Api;

interface QuestionListByCustomerInterface
{

    /**
     * GET for questionList api by customer id
     * @param string $customerId
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByCustomerForApi($customerId);

}
