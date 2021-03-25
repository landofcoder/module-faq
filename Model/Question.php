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
use Lof\Faq\Api\Data\QuestionInterface;

class Question extends \Magento\Framework\Model\AbstractModel implements QuestionInterface, IdentityInterface
{	
	/**
     * Question's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'lof_faq_question';

    /**
     * Product collection factory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * URL Model instance
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    protected $_resource;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;


    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\Faq\Model\ResourceModel\Question $resource = null,
        \Lof\Faq\Model\ResourceModel\Question\Collection $resourceCollection = null,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Lof\Faq\Helper\Data $helper,
        array $data = []
        ) {
        $this->_storeManager = $storeManager;
        $this->_url = $url;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_resource = $resource;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
    }


    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\Faq\Model\ResourceModel\Question');
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
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::QUESTION_ID);
    }
    
    public function getQuestionCategories(){
        if(!$this->_resource){
            $object_manager = \Magento\Framework\App\ObjectManager::getInstance();
            $this->_resource = $object_manager->create("Lof\Faq\Model\ResourceModel\Question");
        }
        $connection = $this->_resource->getConnection();
        $select = 'SELECT * FROM ' . $this->_resource->getTable('lof_faq_question_category') . ' WHERE question_id = ' . $this->getData("question_id");
        $categories = $connection->fetchAll($select);
        $tmp = [];
        foreach ($categories as $k => $v) {
            $select = 'SELECT * FROM ' . $this->_resource->getTable('lof_faq_category') . ' WHERE category_id = ' . $v['category_id'];
            $select = $connection->select()->from(['lof_faq_category' => $this->_resource->getTable('lof_faq_category')])
            ->where('lof_faq_category.category_id = ' . (int)$v['category_id'])
            ->order('lof_faq_category.position DESC');
            $category = $connection->fetchRow($select);
            $tmp[] = $category;
        }
        return $tmp;
    }

    /**
     * Get question_id
     * @return string|null
     */
    public function getQuestionId(){
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * Set question_id
     * @param string $questionId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionId($questionId){
        return $this->setData(self::QUESTION_ID, $questionId);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTitle($title){
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get author_email
     * @return string|null
     */
    public function getAuthorEmail(){
        return $this->getData(self::AUTHOR_EMAIL);
    }

    /**
     * Set author_email
     * @param string $author_email
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAuthorEmail($author_email){
        return $this->setData(self::AUTHOR_EMAIL, $author_email);
    }

    /**
     * Get author_name
     * @return string|null
     */
    public function getAuthorName(){
        return $this->getData(self::AUTHOR_NAME);
    }

    /**
     * Set author_name
     * @param string $author_name
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAuthorName($author_name){
        return $this->setData(self::AUTHOR_NAME, $author_name);
    }

    /**
     * Get answer
     * @return string|null
     */
    public function getAnswer() {
        $answer = $this->helper->filter($this->getData('answer'));
        return $answer;
    }

    /**
     * Set answer
     * @param string $answer
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnswer($answer){
        return $this->setData(self::ANSWER, $answer);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setUpdateTime($update_time){
        return $this->setData(self::UPDATE_TIME,$update_time);
    }
    /**
     * Get is_featured
     * @return bool|null
     */
    public function getIsFeatured(){
        return $this->getData(self::IS_FEATURED);
    }

    /**
     * Set is_featured
     * @param bool\int $is_featured
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setIsFeatured($is_featured){
        return $this->setData(self::IS_FEATURED,$is_featured);
    }
    /**
     * is_active
     * @return bool|null
     */
    public function IsActive(){
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Get is_active
     * @return bool|null
     */
    public function getIsActive(){
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param bool|int $is_active
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setIsActive($is_active){
        return $this->setData(self::IS_ACTIVE, $is_active);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setPageTitle($page_title){
        return $this->setData(self::PAGE_TITLE,$page_title);
    }

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords(){
        return $this->getData(self::META_KEY_WORDS);
    }
    /**
     * Set meta_keywords
     * @param string $meta_keywords
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setMetaKeywords($meta_keywords){
        return $this->setData(self::META_KEY_WORDS,$meta_keywords);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setMetaDescription($meta_description){
        return $this->setData(self::META_DESCRIPTION,$meta_description);
    }

    /**
     * Get question_position
     * @return int|null
     */
    public function getQuestionPosition(){
        return $this->getData(self::QUESTION_POSITION);
    }
    /**
     * Set question_position
     * @param int $question_position
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionPosition($question_position){
        return $this->setData(self::QUESTION_POSITION,$question_position);
    }

    /**
     * Get tag
     * @return string|null
     */
    public function getTag(){
        return $this->getData(self::TAG);
    }
    /**
     * Set tag
     * @param string $tag
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setTag($tag){
        return $this->setData(self::TAG,$tag);
    }

    /**
     * Get like
     * @return int|null
     */
    public function getLike(){
        return $this->getData(self::LIKE);
    }
    /**
     * Set like
     * @param int $like
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setLike($like){
        return $this->setData(self::LIKE,$like);
    }

    /**
     * Get disklike
     * @return int|null
     */
    public function getDiskLike(){
        return $this->getData(self::DISKLIKE);
    }
    /**
     * Set disklike
     * @param int $disklike
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setDiskLike($disklike){
        return $this->setData(self::DISKLIKE,$disklike);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setBodyBg($body_bg){
        return $this->setData(self::BODY_BG,$body_bg);
    }

    /**
     * Get question_margin
     * @return string|null
     */
    public function getQuestionMargin(){
        return $this->getData(self::BODY_BG);
    }
    /**
     * Set question_margin
     * @param string $question_margin
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionMargin($question_margin){
        return $this->setData(self::BODY_BG,$question_margin);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionIcon($question_icon){
        return $this->setData(self::QUESTION_ICON,$question_icon);
    }

    /**
     * Get question_active_icon
     * @return string|null
     */
    public function getQuestionActiveIcon(){
        return $this->getData(self::QUESTION_ICON);
    }
    /**
     * Set question_active_icon
     * @param string $question_active_icon
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionActiveIcon($question_active_icon){
        return $this->setData(self::QUESTION_ICON,$question_active_icon);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnimationClass($animation_class){
        return $this->setData(self::ANIMATION_CLASS,$animation_class);
    }

    /**
     * Get animation_speed
     * @return string|null
     */
    public function getAnimationSpeed(){
        return $this->getData(self::ANIMATION_SPEED);
    }
    /**
     * Set animation_speed
     * @param string $animation_speed
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setAnimationSpeed($animation_speed){
        return $this->setData(self::ANIMATION_SPEED,$animation_speed);
    }


    /**
     * Get question_url
     * @return string|null
     */
    public function getQuestionUrl(){
        return $this->getData(self::QUESTION_URL);
    }

    /**
     * Set question_url
     * @param string $question_url
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setQuestionUrl($question_url){
        return $this->setData(self::QUESTION_URL, $question_url);
    }

    /**
     * Get categories
     * @return string[]|null
     */
    public function getCategories(){
        return $this->getData(self::CATEGORIES);
    }

    /**
     * Set categories
     * @param string[] $categories
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setCategories($categories){
        return $this->setData(self::CATEGORIES,$categories);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setLimit($limit){
        return $this->setData(self::LIMIT,$limit);
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
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function setStores($stores){
        return $this->setData(self::STORES,$stores);
    }

    public function beforeSave()
    {
       return parent::beforeSave();
    }
}
