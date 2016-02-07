<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

abstract class DictionaryCachedStorage implements DictionaryStorageInterface
{
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

    public function __construct(Cache $cache, $dictionaryName, $itemClass)
    {
        $this->dictionaryName = $dictionaryName;
        $this->itemClass = $itemClass;
        $this->cache = $cache;
    }

    /**
     * @return DictionaryItemInterface
     */
    public function createItem()
    {
        $refClass = new \ReflectionClass($this->itemClass);
        $item = $refClass->newInstance();

        return $item;
    }

    /**
     * @param bool $force
     * @return ArrayCollection <DictionaryItemInterface>
     */
    public function loadItems($force = false)
    {
        if ($this->items == null || $this->cache->contains($this->dictionaryName) == false || $force == true) {
            $this->refresh();
        }

        return clone($this->items);
    }

    public function persistItems(ArrayCollection $items)
    {
        $removed = $this->getRemoved($items);
        $this->doPersist($items, $removed);
        $this->refresh();
    }

    public function getItemClass()
    {
        return $this->itemClass;
    }

    /**
     *
     */
    protected function refresh()
    {
        $items = $this->doLoad();
        $collItems = new ArrayCollection();
        foreach ($items as $item) {
            $collItems->set($item->getCode(), $item);
        }
        $this->cache->save($this->dictionaryName, $collItems);
        $this->items = $collItems;
    }

    /**
     * @param ArrayCollection $items
     * @return ArrayCollection
     */
    protected function getRemoved(ArrayCollection $items)
    {
        $arRemoved = array_diff($this->items->getKeys(), $items->getKeys());
        $removed = new ArrayCollection();
        foreach ($arRemoved as $code) {
            $removed->add($this->doLoadItem($code));
        }

        return $removed;
    }

    /**
     * @param string $code
     * @return DictionaryItemInterface
     */
    abstract protected function doLoadItem($code);

    /**
     * @return array|DictionaryItemInterface[]
     */
    abstract protected function doLoad();

    /**
     * @param ArrayCollection $items
     * @param ArrayCollection $removed
     */
    abstract protected function doPersist(ArrayCollection $items, ArrayCollection $removed);
}
