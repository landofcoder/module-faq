<?php


namespace Lof\Faq\Api;

interface QuestionInfoByIdInterface
{
    /**
     * Retrieve question info by id.
     *
     * @param int $questionId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId);

}
