<?php


namespace Lof\Faq\Api;

interface QuestionListByTagInterface
{
    /**
     * GET for questionList api by tag
     * @param string $tagCode
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByTagForApi($tagCode);

}
