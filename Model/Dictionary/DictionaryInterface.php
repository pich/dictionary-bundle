<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryInterface {
	/**
	 * @reutrn ArrayCollection<DictionaryItemInterface>
	 */
	public function getItems();
	
	/**
	 * @param string $code
	 * @return DictionaryItemInterface
	 */
	public function getItem($code);
	
	/**
	 * @return DictionaryItemInterface
	 */
	public function createItem();
	
	/**
	 * @param DictionaryItemInterface $item
	 */
	public function updateItem(DictionaryItemInterface $item);
	
	/**
	 * @param DictionaryItemInterface $item
	 */
	public function removeItem(DictionaryItemInterface $item);
	
	public function commitChanges();
}
?>
