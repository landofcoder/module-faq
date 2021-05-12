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

namespace Lof\Faq\Model;

use Lof\Faq\Model\ResourceModel\Tag\Collection;
use Magento\Framework\DataObject\IdentityInterface;
use Lof\Faq\Api\Data\TagInterface;

class Tag extends \Magento\Framework\Model\AbstractModel implements TagInterface, IdentityInterface
{
    /**
     * Faq's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'lof_faq_question_tag';
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


    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        ResourceModel\Tag $resource = null,
        Collection $resourceCollection = null,
        array $data = []
    ) {
        $this->_storeManager = $storeManager;
        $this->_url = $url;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\Faq\Model\ResourceModel\Tag');
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\Faq\Api\Data\TagExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\Faq\Api\Data\TagExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\Faq\Api\Data\TagExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getUrl()
    {
        $url = $this->_storeManager->getStore()->getBaseUrl();
        $url_prefix = $this->getConfig('general_settings/route');
        $urlPrefix = '';
        if ($url_prefix) {
            $urlPrefix = $url_prefix . '/';
        }
        return $url . $urlPrefix . 'tag/' . $this->getAlias();
    }

    /**
     * Get tag_id
     * @return int|null
     */
    public function getTagId()
    {
        return $this->getData(self::TAG_ID);
    }

    /**
     * Set tag_id
     * @param int $tag_id
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setTagId($tag_id)
    {
        return $this->setData(self::TAG_ID, $tag_id);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get alias
     * @return string|null
     */
    public function getAlias()
    {
        return $this->getData(self::ALIAS);
    }

    /**
     * Set alias
     * @param string $alias
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setAlias($alias)
    {
        return $this->setData(self::ALIAS, $alias);
    }

    /**
     * Get question_id
     * @return int|null
     */
    public function getQuestionId()
    {
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * Set question_id
     * @param int $question_id
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setQuestionId($question_id)
    {
        return $this->setData(self::QUESTION_ID, $question_id);
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
     * Get categories
     * @return string[]|null
     */
    public function getCategories()
    {
        return $this->getData(self::CATEGORIES);
    }

    /**
     * Set categories
     * @param string[] $categories
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setCategories($categories)
    {
        return $this->setData(self::CATEGORIES, $categories);
    }

    /**
     * Get stores
     * @return string[]|null
     */
    public function getStores()
    {
        return $this->getData(self::STORES);
    }
    /**
     * Set stores
     * @param string[] $stores
     * @return \Lof\Faq\Api\Data\TagInterface
     */
    public function setStores($stores)
    {
        return $this->setData(self::STORES, $stores);
    }
}
