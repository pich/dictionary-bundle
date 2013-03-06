<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Collections\ArrayCollection;

interface DictionaryStorageInterface {
	public function getItemClass();
	public function createItem();
	public function loadItems($force = false);
	public function persistItems(ArrayCollection $items);
}
?>
