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
