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

class Networks implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'twitter', 'label' => __('Twitter')],
            ['value' => 'facebook', 'label' => __('Facebook')],
            ['value' => 'googleplus', 'label' => __('Google Plus')],
            ['value' => 'instagram', 'label' => __('Instagram')],
            ['value' => 'linkedin', 'label' => __('LinkedIn')],
            ['value' => 'pinterest', 'label' => __('Pinterest')]
        ];
    }
}
