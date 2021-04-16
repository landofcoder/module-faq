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

namespace Lof\Faq\Model\Data;

use Lof\Faq\Model\QuestionFactory;
use Lof\Faq\Model\ResourceModel\Tag as ResourceTag;
use Lof\Faq\Model\TagFactory;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class Tag
 * @package Lof\Faq\Model\Data
 */
class Tag extends \Magento\Framework\Api\AbstractExtensibleObject implements \Lof\Faq\Api\TagsInterface
{
    /**
     * @var TagFactory
     */
    protected $_tagFactory;
    /**
     * @var ResourceTag
     */
    protected $resource;
    /**
     * @var QuestionFactory
     */
    protected $_questionFactory;

    /**
     * Tag constructor.
     * @param TagFactory $tagFactory
     * @param ResourceTag $resource
     * @param QuestionFactory $questionFactory
     */
    public function __construct(
        TagFactory $tagFactory,
        ResourceTag $resource,
        QuestionFactory $questionFactory
    )
    {
        $this->_tagFactory = $tagFactory;
        $this->_questionFactory = $questionFactory;
        $this->resource = $resource;
    }


    /**
     * @param \Lof\Faq\Api\Data\TagInterface $tag
     * @return bool|\Lof\Faq\Api\Data\TagInterface
     * @throws CouldNotSaveException
     */
    public function save(\Lof\Faq\Api\Data\TagInterface $tag)
    {
        try {
            if ($tag['name'] && $tag['categories'] && $tag['stores']) {
                if (!$tag['alias']) {
                    $tag['alias'] = $this->generateAlias($tag['name']);
                }
                $question = $this->_questionFactory->create()
                    ->load($tag['question_id']);
                $tagCollection = $this->_tagFactory->create()->getCollection();
                $checkUniqueTag = $tagCollection->addFieldToFilter('question_id', $tag['question_id'])->addFieldToFilter('alias', $tag['alias'])->count();

                $getTag = $this->_tagFactory->create()->load($tag['tag_id']);

                if (!empty($getTag->getId())) {
                    $this->resource->save($tag);
                    $question->setData([
                        'question_id' => $tag['question_id'],
                        'tag' => $tag['alias']
                    ])->save();
                    return $tag;
                }
                if ($checkUniqueTag) {
                    return false;
                } else {
                    $tags = !empty($question->getTag()) ? $question->getTag() . ',' . $tag['name'] : $tag['name'];
                    $tag['tag'] = $tags;
                    $question->setData([
                        'question_id' => $tag['question_id'],
                        'tag' => $tags,
                        'stores' => $tag['stores'],
                        'categories' => $tag['categories'],
                    ])->save();
                    return $tag;
                }
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the tag: %1', $exception->getMessage()),
                $exception
            );
        }
        return $tag;
    }

    /**
     * @param int $tagId
     * @return \Lof\Faq\Api\Data\QuestionInterface
     */
    public function getById($tagId)
    {
        $tag = $this->_tagFactory->create()->load($tagId);
        return $tag->getData();
    }

    /**
     * @param $tag_name
     * @return string
     */
    protected function generateAlias($tag_name)
    {
        return strtolower(str_replace(["_", " "], "-", trim($tag_name)));
    }
}
