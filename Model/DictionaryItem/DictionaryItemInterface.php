<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

interface DictionaryItemInterface {
	/**
	 * @return string
	 */
	public function getCode();
	
	/**
	 * @return string
	 */
	public function getLabel();
	
	public function setLabel($label);
}
?>
