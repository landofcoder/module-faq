<?php


namespace Lof\Faq\Api;


use Lof\Faq\Api\Data\TagInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface TagsInterface
 * @package Lof\Faq\Api
 */
interface TagsInterface
{

    /**
     * @param TagInterface $tag
     * @return mixed
     */
    public function save(TagInterface $tag);

    /**
     * @param int $tagId
     * @return TagInterface
     */
    public function getById($tagId);

}
