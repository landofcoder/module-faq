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

interface QuestionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const TITLE = 'title';
    const QUESTION_ID = 'question_id';
    const AUTHOR_EMAIL = 'author_email';
    const AUTHOR_NAME = 'author_name';
    const ANSWER = 'answer';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_FEATURED = 'is_featured';
    const IS_ACTIVE = 'is_active';
    const PAGE_TITLE = 'page_title';
    const META_KEY_WORDS = 'meta_keywords';
    const META_DESCRIPTION = 'meta_description';
    const QUESTION_POSITION = 'question_position';
    const TAG = 'tag';
    const LIKE = 'like';
    const DISKLIKE = 'disklike';
    const TITLE_SIZE = 'title_size';
    const TITLE_COLOR = 'title_color';
    const TITLE_COLOR_ACTIVE = 'title_color_active';
    const TITLE_BG = 'title_bg';
    const TITLE_BG_ACTIVE = 'title_bg_active';
    const BORDER_WIDTH = 'border_width';
    const TITLE_BORDER_COLOR = 'title_border_color';
    const TITLE_BORDER_RADIUS = 'title_border_radius';
    const BODY_SIZE = 'body_size';
    const BODY_COLOR = 'body_color';
    const BODY_BG = 'body_bg';
    const QUESTION_MARGIN = 'question_margin';
    const QUESTION_ICON = 'question_icon';
    const QUESTION_ACTIVE_ICON = 'question_active_icon';
    const ANIMATION_CLASS = 'animation_class';
    const ANIMATION_SPEED = 'animation_speed';
    const QUESTION_URL = 'question_url';
    const CATEGORIES = 'categories';
    const LIMIT = 'limit';
    const STORES = 'stores';

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\Faq\Api\Data\QuestionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\Faq\Api\Data\QuestionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\Faq\Api\Data\QuestionExtensionInterface $extensionAttributes
    );

    /**
     * Get question_id
     * @return int|null
     */
    public function getQuestionId();

    /**
     * Set question_id
     * @param int $questionId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionId($questionId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitle($title);

    /**
     * Get author_email
     * @return string|null
     */
    public function getAuthorEmail();

    /**
     * Set author_email
     * @param string $author_email
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAuthorEmail($author_email);

    /**
     * Get author_name
     * @return string|null
     */
    public function getAuthorName();

    /**
     * Set author_name
     * @param string $author_name
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAuthorName($author_name);

    /**
     * Get answer
     * @return string|null
     */
    public function getAnswer();

    /**
     * Set answer
     * @param string $answer
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnswer($answer);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creation_time
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setCreationTime($creation_time);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $update_time
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setUpdateTime($update_time);
    /**
     * Get is_featured
     * @return bool|null
     */
    public function getIsFeatured();

    /**
     * Set is_featured
     * @param bool\int $is_featured
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setIsFeatured($is_featured);

    /**
     * is_active
     * @return bool|null
     */
    public function IsActive();

    /**
     * Get is_active
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param bool|int $is_active
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setIsActive($is_active);

    /**
     * Get page_title
     * @return string|null
     */
    public function getPageTitle();

    /**
     * Set page_title
     * @param string $page_title
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setPageTitle($page_title);

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords();
    /**
     * Set meta_keywords
     * @param string $meta_keywords
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setMetaKeywords($meta_keywords);

    /**
     * Get meta_description
     * @return string|null
     */
    public function getMetaDescription();
    /**
     * Set meta_description
     * @param string $meta_description
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setMetaDescription($meta_description);

    /**
     * Get question_position
     * @return int|null
     */
    public function getQuestionPosition();
    /**
     * Set question_position
     * @param int $question_position
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionPosition($question_position);

    /**
     * Get tag
     * @return string|null
     */
    public function getTag();
    /**
     * Set tag
     * @param string $tag
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTag($tag);

    /**
     * Get like
     * @return int|null
     */
    public function getLike();
    /**
     * Set like
     * @param int $like
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setLike($like);

    /**
     * Get disklike
     * @return int|null
     */
    public function getDiskLike();
    /**
     * Set disklike
     * @param int $disklike
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setDiskLike($disklike);

    /**
     * Get title_size
     * @return string|null
     */
    public function getTitleSize();
    /**
     * Set title_size
     * @param string $title_size
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleSize($title_size);

    /**
     * Get title_color
     * @return string|null
     */
    public function getTitleColor();
    /**
     * Set title_color
     * @param string $title_color
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleColor($title_color);

    /**
     * Get title_color_active
     * @return string|null
     */
    public function getTitleColorActive();
    /**
     * Set title_color_active
     * @param string $title_color_active
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleColorActive($title_color_active);

    /**
     * Get title_bg
     * @return string|null
     */
    public function getTitleBg();
    /**
     * Set title_bg
     * @param string $title_bg
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleBg($title_bg);

    /**
     * Get title_bg_active
     * @return string|null
     */
    public function getTitleBgActive();
    /**
     * Set title_bg_active
     * @param string $title_bg_active
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleBgActive($title_bg_active);

    /**
     * Get border_width
     * @return string|null
     */
    public function getBorderWidth();
    /**
     * Set border_width
     * @param string $border_width
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setBorderWidth($border_width);

    /**
     * Get title_border_color
     * @return string|null
     */
    public function getTitleBorderColor();
    /**
     * Set title_border_color
     * @param string $title_border_color
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleBorderColor($title_border_color);

    /**
     * Get title_border_radius
     * @return string|null
     */
    public function getTitleBorderRadius();
    /**
     * Set title_border_radius
     * @param string $title_border_radius
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitleBorderRadius($title_border_radius);

    /**
     * Get body_size
     * @return string|null
     */
    public function getBodySize();
    /**
     * Set body_size
     * @param string $body_size
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setBodySize($body_size);

    /**
     * Get body_color
     * @return string|null
     */
    public function getBodyColor();
    /**
     * Set body_color
     * @param string $body_color
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setBodyColor($body_color);

    /**
     * Get body_bg
     * @return string|null
     */
    public function getBodyBg();
    /**
     * Set body_bg
     * @param string $body_bg
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setBodyBg($body_bg);

    /**
     * Get question_margin
     * @return string|null
     */
    public function getQuestionMargin();
    /**
     * Set question_margin
     * @param string $question_margin
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionMargin($question_margin);

    /**
     * Get question_icon
     * @return string|null
     */
    public function getQuestionIcon();
    /**
     * Set question_icon
     * @param string $question_icon
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionIcon($question_icon);

    /**
     * Get question_active_icon
     * @return string|null
     */
    public function getQuestionActiveIcon();
    /**
     * Set question_active_icon
     * @param string $question_active_icon
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionActiveIcon($question_active_icon);

    /**
     * Get animation_class
     * @return string|null
     */
    public function getAnimationClass();
    /**
     * Set animation_class
     * @param string $animation_class
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnimationClass($animation_class);

    /**
     * Get animation_speed
     * @return string|null
     */
    public function getAnimationSpeed();
    /**
     * Set animation_speed
     * @param string $animation_speed
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnimationSpeed($animation_speed);

    /**
     * Get question_url
     * @return string|null
     */
    public function getQuestionUrl();

    /**
     * Set question_url
     * @param string $question_url
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionUrl($question_url);

    /**
     * Get categories
     * @return string[]|null
     */
    public function getCategories();

    /**
     * Set categories
     * @param string $categories
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setCategories($categories);

    /**
     * Get limit
     * @return string|null
     */
    public function getLimit();

    /**
     * Set limit
     * @param string $limit
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setLimit($limit);

    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores();
    /**
     * Set stores
     * @param string[] $stores
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setStores($stores);
}
