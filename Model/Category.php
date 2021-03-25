<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_FAQ
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\Faq\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Lof\Faq\Api\Data\CategoryInterface;

class Category extends \Magento\Framework\Model\AbstractModel implements CategoryInterface, IdentityInterface
{
    /**
     * Category's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'lof_faq_question';
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\Faq\Model\ResourceModel\Category');
    }
    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategory_id(){
        return $this->getData(self::CATEGORY_ID);
    }
    /**
     * Set category_id
     * @param string $category_id
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCategory_id($category_id){
        return $this->setData(self::CATEGORY_ID,$category_id);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle(){
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitle($title){
        return $this->setData(self::TITLE,$title);
    }

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier(){
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Set alias
     * @param string identifier
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIdentifier($identifier){
        return $this->setData(self::IDENTIFIER,$identifier);
    }

    /**
     * Get category_id
     * @return int|null
     */
    public function getCategoryId(){
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * Set category_id
     * @param int category_id
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCategoryId($category_id){
        return $this->setData(self::CATEGORY_ID,$category_id);
    }

    /**
     * Get page_title
     * @return string|null
     */
    public function getPageTitle(){
        return $this->getData(self::PAGE_TITLE);
    }

    /**
     * Set page_title
     * @param string $page_title
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPageTitle($page_title){
        return $this->setData(self::PAGE_TITLE,$page_title);
    }

    /**
     * Get grid_column
     * @return string|null
     */
    public function getGridColumn(){
        return $this->getData(self::GRID_COLUMN);
    }

    /**
     * Set grid_column
     * @param string $grid_column
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setGridColumn($grid_column){
        return $this->setData(self::GRID_COLUMN,$grid_column);
    }

    /**
     * Get layout_type
     * @return string|null
     */
    public function getLayoutType(){
        return $this->getData(self::LAYOUT_TYPE);
    }

    /**
     * Set layout_type
     * @param string $layout_type
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLayoutType($layout_type){
        return $this->setData(self::LAYOUT_TYPE,$layout_type);
    }

    /**
     * Get page_layout
     * @return string|null
     */
    public function getPageLayout(){
        return $this->getData(self::PAGE_LAYOUT);
    }

    /**
     * Set page_layout
     * @param string $page_layout
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPageLayout($page_layout){
        return $this->setData(self::PAGE_LAYOUT,$page_layout);
    }

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords(){
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * Set meta_keywords
     * @param string $meta_keywords
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setMetaKeywords($meta_keywords){
        return $this->setData(self::META_KEYWORDS,$meta_keywords);
    }

    /**
     * Get meta_description
     * @return string|null
     */
    public function getMetaDescription(){
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * Set meta_description
     * @param string $meta_description
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setMetaDescription($meta_description){
        return $this->setData(self::META_DESCRIPTION,$meta_description);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage(){
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setImage($image){
        return $this->setData(self::IMAGE,$image);
    }

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Set creation_time
     * @param string $creation_time
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCreationTime($creation_time){
        return $this->setData(self::CREATION_TIME,$creation_time);
    }

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime(){
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set update_time
     * @param string $update_time
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setUpdateTime($update_time){
        return $this->setData(self::UPDATE_TIME,$update_time);
    }

    /**
     * Get position
     * @return int|null
     */
    public function getPosition(){
        return $this->getData(self::POSITION);
    }

    /**
     * Set position
     * @param int $position
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPosition($position){
        return $this->setData(self::POSITION,$position);
    }

    /**
     * Get include_in_sidebar
     * @return int|null
     */
    public function getIncludeInSidebar(){
        return $this->getData(self::INCLUDE_IN_SIDEBAR);
    }
    /**
     * Set include_in_sidebar
     * @param int $include_in_sidebar
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIncludeInSidebar($include_in_sidebar){
        return $this->setData(self::INCLUDE_IN_SIDEBAR,$include_in_sidebar);
    }


    /**
     * Get is_active
     * @return bool|null
     */
    public function getIsActive(){
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param int|bool $is_active
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setIsActive($is_active){
        return $this->setData(self::IS_ACTIVE,$is_active);
    }

    /**
     * Get description
     * @return string|null
     */
    public function getDescription(){
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setDescription($description){
        return $this->setData(self::DESCRIPTION,$description);
    }

    /**
     * Get parent_id
     * @return string|null
     */
    public function getParentId(){
        return $this->getData(self::PARENT_ID);
    }
    /**
     * Set parent_id
     * @param string $parent_id
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setParentId($parent_id){
        return $this->setData(self::PARENT_ID,$parent_id);
    }

    /**
     * Get title_size
     * @return string|null
     */
    public function getTitleSize(){
        return $this->getData(self::TITLE_SIZE);
    }
    /**
     * Set title_size
     * @param string $title_size
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleSize($title_size){
        return $this->setData(self::TITLE_SIZE,$title_size);
    }

    /**
     * Get title_color
     * @return string|null
     */
    public function getTitleColor(){
        return $this->getData(self::TITLE_COLOR);
    }
    /**
     * Set title_color
     * @param string $title_color
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleColor($title_color){
        return $this->setData(self::TITLE_COLOR,$title_color);
    }

    /**
     * Get title_color_active
     * @return string|null
     */
    public function getTitleColorActive(){
        return $this->getData(self::TITLE_COLOR_ACTIVE);
    }
    /**
     * Set title_color_active
     * @param string $title_color_active
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleColorActive($title_color_active){
        return $this->setData(self::TITLE_COLOR_ACTIVE,$title_color_active);
    }

    /**
     * Get title_bg
     * @return string|null
     */
    public function getTitleBg(){
        return $this->getData(self::TITLE_BG);
    }
    /**
     * Set title_bg
     * @param string $title_bg
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleBg($title_bg){
        return $this->setData(self::TITLE_BG,$title_bg);
    }

    /**
     * Get title_bg_active
     * @return string|null
     */
    public function getTitleBgActive(){
        return $this->getData(self::TITLE_BG_ACTIVE);
    }
    /**
     * Set title_bg_active
     * @param string $title_bg_active
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleBgActive($title_bg_active){
        return $this->setData(self::TITLE_BG_ACTIVE,$title_bg_active);
    }

    /**
     * Get border_width
     * @return string|null
     */
    public function getBorderWidth(){
        return $this->getData(self::BORDER_WIDTH);
    }
    /**
     * Set border_width
     * @param string $border_width
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setBorderWidth($border_width){
        return $this->setData(self::BORDER_WIDTH,$border_width);
    }

    /**
     * Get title_border_color
     * @return string|null
     */
    public function getTitleBorderColor(){
        return $this->getData(self::TITLE_BORDER_COLOR);
    }
    /**
     * Set title_border_color
     * @param string $title_border_color
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleBorderColor($title_border_color){
        return $this->setData(self::TITLE_BORDER_COLOR,$title_border_color);
    }

    /**
     * Get title_border_radius
     * @return string|null
     */
    public function getTitleBorderRadius(){
        return $this->getData(self::TITLE_BORDER_RADIUS);
    }
    /**
     * Set title_border_radius
     * @param string $title_border_radius
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setTitleBorderRadius($title_border_radius){
        return $this->setData(self::TITLE_BORDER_RADIUS,$title_border_radius);
    }

    /**
     * Get body_size
     * @return string|null
     */
    public function getBodySize(){
        return $this->getData(self::BODY_SIZE);
    }
    /**
     * Set body_size
     * @param string $body_size
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setBodySize($body_size){
        return $this->setData(self::BODY_SIZE,$body_size);
    }

    /**
     * Get body_color
     * @return string|null
     */
    public function getBodyColor(){
        return $this->getData(self::BODY_COLOR);
    }
    /**
     * Set body_color
     * @param string $body_color
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setBodyColor($body_color){
        return $this->setData(self::BODY_COLOR,$body_color);
    }

    /**
     * Get body_bg
     * @return string|null
     */
    public function getBodyBg(){
        return $this->getData(self::BODY_BG);
    }
    /**
     * Set body_bg
     * @param string $body_bg
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setBodyBg($body_bg){
        return $this->setData(self::BODY_BG,$body_bg);
    }

    /**
     * Get question_margin
     * @return string|null
     */
    public function getQuestionMargin(){
        return $this->getData(self::QUESTION_MARGIN);
    }
    /**
     * Set question_margin
     * @param string $question_margin
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setQuestionMargin($question_margin){
        return $this->setData(self::QUESTION_MARGIN,$question_margin);
    }

    /**
     * Get question_icon
     * @return string|null
     */
    public function getQuestionIcon(){
        return $this->getData(self::QUESTION_ICON);
    }
    /**
     * Set question_icon
     * @param string $question_icon
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setQuestionIcon($question_icon){
        return $this->setData(self::QUESTION_ICON,$question_icon);
    }

    /**
     * Get question_active_icon
     * @return string|null
     */
    public function getQuestionActiveIcon(){
        return $this->getData(self::QUESTION_ACTIVE_ICON);
    }
    /**
     * Set question_active_icon
     * @param string $question_active_icon
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setQuestionActiveIcon($question_active_icon){
        return $this->setData(self::QUESTION_ACTIVE_ICON,$question_active_icon);
    }

    /**
     * Get animation_class
     * @return string|null
     */
    public function getAnimationClass(){
        return $this->getData(self::ANIMATION_CLASS);
    }
    /**
     * Set animation_class
     * @param string $animation_class
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setAnimationClass($animation_class){
        return $this->setData(self::ANIMATION_CLASS,$animation_class);
    }

    /**
     * Get animation_speed
     * @return string|null
     */
    public function getAnimationSpeed(){
        return $this->getData(self::ANIMATION_CLASS);
    }
    /**
     * Set animation_speed
     * @param string $animation_speed
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setAnimationSpeed($animation_speed){
        return $this->setData(self::ANIMATION_CLASS,$animation_speed);
    }

    /**
     * Get cat_icon
     * @return string|null
     */
    public function getCatIcon(){
        return $this->getData(self::CAT_ICON);
    }
    /**
     * Set cat_icon
     * @param string $cat_icon
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setCatIcon($cat_icon){
        return $this->setData(self::CAT_ICON,$cat_icon);
    }

    /**
     * Get limit
     * @return string|null
     */
    public function getLimit(){
        return $this->getData(self::LIMIT);
    }
    /**
     * Set limit
     * @param string $limit
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLimit($limit){
        return $this->setData(self::LIMIT,$limit);
    }

    /**
     * Get page
     * @return string|null
     */
    public function getPage(){
        return $this->getData(self::PAGE);
    }
    /**
     * Set page
     * @param string $page
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setPage($page){
        return $this->setData(self::PAGE,$page);
    }

    /**
     * Get links
     * @return string[]|null
     */
    public function getLinks(){
        return $this->getData(self::LINKS);
    }
    /**
     * Set links
     * @param string[] $links
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setLinks($links){
        return $this->setData(self::LINKS,$links);
    }

    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores(){
        return $this->getData(self::STORES);
    }
    /**
     * Set stores
     * @param string[] $stores
     * @return \Lof\Faq\Api\Data\CategoryInterface
     */
    public function setStores($stores){
        return $this->setData(self::STORES,$stores);
    }

}
