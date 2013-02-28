<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryStorageInterface {
	public function createItem();
	public function loadItems($force = false);
	public function persistItems(ArrayCollection $items);
}
?>
