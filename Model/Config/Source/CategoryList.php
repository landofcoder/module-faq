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
namespace Lof\Faq\Model\Config\Source;

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\User\Model\UserFactory
     */
	protected $_categoryFactory;

    /**
     * @param \Lof\Faq\Model\Category
     */
	public function __construct(
		\Lof\Faq\Model\Category $categoryFactory
		){
		$this->_categoryFactory = $categoryFactory;
	}

    public function toOptionArray()
    {
    	$options = [];
        $collection = $this->_categoryFactory->getCollection();
        foreach ($collection as $_cat) {
        	$options[] = [
                'label' => $_cat->getTitle(),
                'value' => $_cat->getCategoryId()
            ];
        }
        return $options;
    }
}
