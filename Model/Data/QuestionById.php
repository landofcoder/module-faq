<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_Faq
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lof\Faq\Model\Data;
use Lof\Faq\Block\Product\View\Faq;

class QuestionById implements \Lof\Faq\Api\QuestionInfoByIdInterface
{
    protected $_resource;
    protected $_productFaq;
    protected $_questionFactory;
    public function __construct(\Lof\Faq\Model\QuestionFactory $questionFactory,
                                Faq $productFaq,
                                \Magento\Framework\App\ResourceConnection $resource)
    {
        $this->_questionFactory = $questionFactory;
        $this->_productFaq = $productFaq;
        $this->_resource = $resource;
    }

    /**
     * Retrieve question info by id.
     *
     * @param int $questionId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId){
        $question = $this->_questionFactory->create();
        $question->load($questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('The faq question with the "%1" ID doesn\'t exist.', $questionId));
        }
        if (!$question->isActive()) {
            throw new NoSuchEntityException(__('The faq question with the "%1" ID is not active.', $questionId));
        }
        return $question;
    }

}
