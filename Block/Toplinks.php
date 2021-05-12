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
namespace Lof\Faq\Block;

class Toplinks extends \Magento\Framework\View\Element\Template
{
	/**
	 * @param \Magento\Framework\View\Element\Template\Context
	 * @param \Lof\Faq\Helper\Data
	 * @param array
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Lof\Faq\Helper\Data $helper,
		array $data = []
		) {
		parent::__construct($context, $data);
		$this->_helper       = $helper;
	}

	/**
     * Render block HTML
     *
     * @return string
     */
	protected function _toHtml()
	{
		if(!$this->_helper->getConfig('general_settings/enable')) return;
		$route = $this->_helper->getConfig('general_settings/route');

		$link = '';
		if($route){
			$link .= '<li><a href="' . $this->getUrl('', array('_direct'=>$route)) . '" title="FAQ">FAQ</a></li>';
		}
		return $link;
	}
}
