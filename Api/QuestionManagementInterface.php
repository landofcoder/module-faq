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

namespace Lof\Faq\Api;

use Lof\Faq\Api\Data\QuestionInterface;

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

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param $search
     * @param $tag
     * @param $identifier
     * @param $sku
     * @return \Lof\Faq\Api\Data\CategorySearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        $search,
        $tag,
        $identifier,
        $sku
    );
}
