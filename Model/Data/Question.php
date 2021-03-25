<?php

namespace Lof\Faq\Model\Data;

use Lof\Faq\Api\Data\QuestionInterface;
use Lof\Faq\Api\QuestionManagementInterface;
use Lof\Faq\Model\QuestionFactory;
use Lof\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magento\Backend\Helper\Js;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Question
 * @package Lof\Faq\Model\Data
 */
class Question implements QuestionManagementInterface
{
    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;
    /**
     * @var Js
     */
    protected $jsHelper;
    /**
     * @var ResourceQuestion
     */
    protected $resource;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Question constructor.
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param Js $jsHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        QuestionFactory $questionFactory,
        Js $jsHelper,
        StoreManagerInterface $storeManager,
        ResourceQuestion $resource)
    {
        $this->_questionFactory = $questionFactory;
        $this->jsHelper = $jsHelper;
        $this->storeManager = $storeManager;
        $this->resource = $resource;
    }


    /**
     * @param QuestionInterface $question
     * @return bool|QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question)
    {
        if ($question['title'] && $question['categories'] && $question['stores']) {
            try {
                $this->resource->save($question);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(
                    __('Could not save the question: %1', $exception->getMessage()),
                    $exception
                );
            }
            return $question;
        } else {
            return false;
        }
    }


    /**
     * @param QuestionInterface $question
     * @return bool|QuestionInterface
     * @throws CouldNotSaveException
     */
    public function saveInFrontend(QuestionInterface $question)
    {
        if ($question['author_name'] && $question['title'] && $question['author_email'] && $question['stores']) {
            try {
                $this->resource->save($question);
            } catch (\Exception $exception) {
                throw new CouldNotSaveException(
                    __('Could not save the question: %1', $exception->getMessage()),
                    $exception
                );
            }
            return $question;
        } else {
            return false;
        }
    }


    /**
     * @param int $questionId
     * @return QuestionInterface
     */
    public function getById($questionId)
    {
        $question = $this->_questionFactory->create()->load($questionId);
        return $question->getData();
    }
}
