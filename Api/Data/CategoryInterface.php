<?php


namespace Lof\Faq\Api\Data;

interface CategoryInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CATEGORY_ID = 'category_id';
    const TITLE = 'title';
    const PAGE_TITLE = 'page_title';
    const IDENTIFIER = 'identifier';
    const DESCRIPTION = 'description';
    const GRID_COLUMN = 'grid_column';
    const LAYOUT_TYPE = 'layout_type';
    const PAGE_LAYOUT = 'page_layout';
    const META_KEYWORDS = 'meta_keywords';
    const META_DESCRIPTION = 'meta_description';
    const IMAGE = 'image';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const POSITION = 'position';
    const INCLUDE_IN_SIDEBAR = 'include_in_sidebar';
    const IS_ACTIVE = 'is_active';
    const PARENT_ID = 'parent_id';
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
    const CAT_ICON = 'cat_icon';
    const LIMIT = 'limit';
    const PAGE = 'page';
    const LINKS = 'links';
    const STORES = 'stores';

    /**
     * Get category_id
     * @return int|null
     */
    public function getCategoryId();

    /**
     * Set category_id
     * @param int category_id
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCategoryId($category_id);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitle($title);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set alias
     * @param string identifier
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get page_title
     * @return string|null
     */
    public function getPageTitle();

    /**
     * Set page_title
     * @param string $page_title
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPageTitle($page_title);

    /**
     * Get grid_column
     * @return string|null
     */
    public function getGridColumn();

    /**
     * Set grid_column
     * @param string $grid_column
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setGridColumn($grid_column);

    /**
     * Get layout_type
     * @return string|null
     */
    public function getLayoutType();

    /**
     * Set layout_type
     * @param string $layout_type
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLayoutType($layout_type);

    /**
     * Get page_layout
     * @return string|null
     */
    public function getPageLayout();

    /**
     * Set page_layout
     * @param string $page_layout
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPageLayout($page_layout);

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords();

    /**
     * Set meta_keywords
     * @param string $meta_keywords
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setMetaDescription($meta_description);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setImage($image);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creation_time
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setUpdateTime($update_time);

    /**
     * Get position
     * @return int|null
     */
    public function getPosition();

    /**
     * Set position
     * @param int $position
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPosition($position);

    /**
     * Get include_in_sidebar
     * @return int|null
     */
    public function getIncludeInSidebar();
    /**
     * Set include_in_sidebar
     * @param int $include_in_sidebar
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIncludeInSidebar($include_in_sidebar);

    /**
     * Get is_active
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param int|bool $is_active
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIsActive($is_active);


    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setDescription($description);

    /**
     * Get parent_id
     * @return string|null
     */
    public function getParentId();
    /**
     * Set parent_id
     * @param string $parent_id
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setParentId($parent_id);

    /**
     * Get title_size
     * @return string|null
     */
    public function getTitleSize();
    /**
     * Set title_size
     * @param string $title_size
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
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
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setAnimationSpeed($animation_speed);

    /**
     * Get cat_icon
     * @return string|null
     */
    public function getCatIcon();
    /**
     * Set cat_icon
     * @param string $cat_icon
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCatIcon($cat_icon);

    /**
     * Get limit
     * @return string|null
     */
    public function getLimit();
    /**
     * Set limit
     * @param string $limit
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLimit($limit);

    /**
     * Get page
     * @return string|null
     */
    public function getPage();
    /**
     * Set page
     * @param string $page
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPage($page);

    /**
     * Get links
     * @return string[]|null
     */
    public function getLinks();
    /**
     * Set links
     * @param string[] $links
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLinks($links);

    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores();
    /**
     * Set stores
     * @param string[] $stores
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setStores($stores);

}
