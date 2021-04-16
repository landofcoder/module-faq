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
