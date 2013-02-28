<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Cache\Cache;

abstract class DictionaryCachedStorage implements DictionaryLoaderInterface {
	/**
	 * @var string
	 */
	protected $dictionaryName;
	
	/**
	 * @var Cache
	 */
	protected $cache;
	
	/**
	 * @var string
	 */
	protected $itemClass;
	
	/**
	 * @var ArrayCollection
	 */
	protected $items;
	
	public function __construct(Cache $cache, $dictionaryName, $itemClass) {
		$this->dictionaryName = $dictionaryName;
		$this->itemClass = $itemClass;
		$this->cache = $cache;
	}
	
	public function createItem() {
		$refClass = new \ReflectionClass($this->itemClass);
		$item = $refClass->newInstance();
		
		return $item;
	}
	
	public function loadItems($force = false) {
		if($this->items == null || $this->cache->contains($this->dictionaryName) == false || $force == true) {
			$this->refresh();
		}
		
		return $this->items;
	}
	
	public function persistItems(ArrayCollection $items) {
		$this->doPersist($items);
		$this->refresh();
	}
	
	protected function refresh() {
		$items = $this->doLoad();
		$collItems = new ArrayCollection();
		foreach($items as $item) {
			$collItems->set($item->getCode(), $item);
		}
		$this->cache->save($this->dictionaryName, $collItems);
		$this->items = $collItems;
	}
	
	abstract protected function doLoad();
	
	abstract protected function doPersist(ArrayCollection $items);
}
?>
