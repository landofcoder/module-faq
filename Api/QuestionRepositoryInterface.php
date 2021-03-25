<?php


namespace Lof\Faq\Api;

interface QuestionRepositoryInterface
{

    /**
     * GET for questionList api by title,answer,tag
     * @param string $keyWord
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListByKeyword($keyWord);

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @return \Lof\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList();
}
