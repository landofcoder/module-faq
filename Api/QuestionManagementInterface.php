<?php


namespace Lof\Faq\Api;

use Lof\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface QuestionManagementInterface
 * @package Lof\Faq\Api
 */
interface QuestionManagementInterface
{

    /**
     * @param QuestionInterface $question
     * @return mixed
     */
    public function save(QuestionInterface $question);


    /**
     * @param QuestionInterface $question
     * @return mixed
     */
    public function saveInFrontend(QuestionInterface $question);


    /**
     * @param $questionId
     * @return mixed
     */
    public function getById($questionId);

}
