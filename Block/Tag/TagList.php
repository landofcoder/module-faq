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
namespace Lof\Faq\Block\Tag;

class TagList extends \Magento\Framework\View\Element\Template
{
	/**
	 * @var \Lof\Faq\Helper\Data
	 */
	protected $_faqHelper;

	/**
	 * @var \Lof\Faq\Model\Tag
	 */
	protected $_tag;


	/**
	 * @var \Lof\Faq\Model\ResourceModel\Tag\Collection
	 */
	protected $_colleciton;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context
	 * @param \Lof\Faq\Helper\Data
	 * @param \Lof\Faq\Model\Tag
	 * @param array
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Lof\Faq\Helper\Data $faqHelper,
		\Lof\Faq\Model\Tag $tag,
		array $data = []
		) {
		parent::__construct($context, $data);
		$this->_faqHelper = $faqHelper;
		$this->_tag = $tag;
	}

	public function _toHtml(){
        $store = $this->_storeManager->getStore();
		$itemPerPage = $this->_faqHelper->getConfig('sidebar/tags_per_page');
		if($this->getConfig('item_per_page')){
			$itemPerPage = $this->getConfig('item_per_page');
		}
		$collection = $this->_tag->getCollection();
        $collection->addStoreFilter($store);
		$tags = [];
		foreach ($collection as $k => $v) {
//            var_dump($v['alias']);die('asdasdasd');
			$count = 1;
			if(isset($tags[$v['alias']])){
				$count = $tags[$v['alias']]['count']+1;
			}
			$tags[$v['alias']] = [
				'name' => $v['name'],
				'count' => $count
			];
			$count++;
		}

		$newTags = [];
		$i=0;
		foreach ($tags as $k => $v) {
			$newTags[$k] = $v;
			if($itemPerPage && ($i == ($itemPerPage-1))){
				break;
			}
			$i++;
		}
		$this->setData("tags", $newTags);
		return parent::_toHtml();
	}

	public function getConfig($key, $default = '')
	{   
		$c = explode("/", $key);
		if(count($c)==2){
			if($this->hasData($c[1])){
				return $this->getData($c[1]);
			}
		}
		if($this->hasData($key)){
			return $this->getData($key);
		}
		return $default;
	}
}