<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

class Dictionary implements DictionaryInterface
{
    /**
     * @var DictionaryStorageInterface
     */
    protected $storage;

    /**
     *
     * @var ArrayCollection
     */
    protected $items;

    public function __construct(DictionaryStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @reutrn ArrayCollection<DictionaryItemInterface>
     */
    public function getItems()
    {
        if ($this->items == null) {
            $this->items = $this->storage->loadItems();
        }

        return $this->items;
    }

    /**
     * @param string $code
     * @return DictionaryItemInterface
     */
    public function getItem($code)
    {
        if ($this->items == null) {
            $this->items = $this->storage->loadItems();
        }

        $item = $this->items->containsKey($code) ? $this->items->get($code) : null;

        return $item;
    }

    /**
     * @return DictionaryItemInterface
     */
    public function createItem()
    {
        return $this->storage->createItem();
    }

    /**
     * @param DictionaryItemInterface $item
     * @return DictionaryItemInterface
     */
    public function updateItem(DictionaryItemInterface $item)
    {
        $this->getItems()->set($item->getCode(), $item);

        return $item;
    }

    /**
     * @param DictionaryItemInterface $item
     */
    public function removeItem(DictionaryItemInterface $item)
    {
        $this->getItems()->remove($item->getCode());
    }

    public function getItemClass()
    {
        return $this->storage->getItemClass();
    }

    public function purge()
    {
        foreach ($this->getItems() as $item) {
            $this->removeItem($item);
        }
    }

    public function commitChanges()
    {
        if ($this->items) {
            $this->storage->persistItems($this->items);
        }
    }
}
