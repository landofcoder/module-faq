<?php


namespace Lof\Faq\Api;

/**
 * Interface QuestionListByCategoryInterface
 * @package Lof\Faq\Api
 */
interface QuestionListByCategoryInterface
{

    /**
     * GET for questionList api by category id
     * @param string $categoryId
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuestionByCategoryForApi($categoryId);

}
