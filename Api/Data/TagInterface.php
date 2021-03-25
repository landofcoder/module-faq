<?php


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
