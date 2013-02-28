<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

interface DictionaryItemInterface {
	/**
	 * @return string
	 */
	public function getCode();
	
	public function setCode($code);
	
	/**
	 * @return string
	 */
	public function getLabel();
	
	public function setLabel($label);
}
?>
