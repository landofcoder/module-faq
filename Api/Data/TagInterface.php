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

namespace Lof\Faq\Api\Data;

interface TagInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const TAG_ID = 'tag_id';
    const NAME = 'name';
    const ALIAS = 'alias';
    const QUESTION_ID = 'question_id';
    const CATEGORY_ID = 'tag_id';
    const STORES = 'stores';
    const CATEGORIES = 'categories';

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\Faq\Api\Data\TagExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\Faq\Api\Data\TagExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\Faq\Api\Data\TagExtensionInterface $extensionAttributes
    );

    /**
     * Get tag_id
     * @return int|null
     */
    public function getTagId();

    /**
     * Set tag_id
     * @param int $tag_id
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setTagId($tag_id);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setName($name);
    /**
     * Get alias
     * @return string|null
     */
    public function getAlias();

    /**
     * Set alias
     * @param string $alias
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setAlias($alias);

    /**
     * Get question_id
     * @return int|null
     */
    public function getQuestionId();

    /**
     * Set question_id
     * @param int $question_id
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setQuestionId($question_id);

    /**
     * Get categories
     * @return string[]|null
     */
    public function getCategories();

    /**
     * Set categories
     * @param string[] $categories
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setCategories($categories);

    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores();
    /**
     * Set stores
     * @param string[] $stores
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setStores($stores);

}
