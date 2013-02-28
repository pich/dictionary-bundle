<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

class Dictionary implements DictionaryInterface {
	/**
	 * @var DictionaryStorageInterface
	 */
	private $storage;
	
	/**
	 * 
	 * @var ArrayCollection
	 */
	private $items;
	
	public function __construct(DictionaryStorageInterface $storage) {
		$this->storage = $storage;
	}
	
	/**
	 * @reutrn ArrayCollection<DictionaryItemInterface>
	 */
	public function getItems() {
		if($this->items == null) {
			$this->items = $this->storage->loadItems();
		}
		
		return $this->items; 
	}
	
	/**
	 * @param string $code
	 * @return DictionaryItemInterface
	 */
	public function getItem($code) {
		if($this->items == null) {
			$this->items = $this->storage->loadItems();
		}
		
		$item = $this->items->containsKey($code) ? $this->items->get($code) : null;
		
		return $item;
	}
	
	/**
	 * @return DictionaryItemInterface
	 */
	public function createItem() {
		return $this->storage->createItem();
	}
	
	/**
	 * @param DictionaryItemInterface $item
	 */
	public function updateItem(DictionaryItemInterface $item) {
		$this->items->set($item->getCode(),$item);
	}
	
	/**
	 * @param DictionaryItemInterface $item
	 */
	public function removeItem(DictionaryItemInterface $item) {
		$this->getItems()->remove($item->getCode());
	}
	
	public function commitChanges() {
		if($this->items) {
			$this->storage->persistItems($this->items);
		}
	}
}
?>
