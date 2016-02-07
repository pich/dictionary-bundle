<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

interface DictionaryStorageInterface
{
    /**
     * @return string
     */
    public function getItemClass();

    /**
     * @return DictionaryItemInterface
     */
    public function createItem();

    /**
     * @param bool $force
     * @return ArrayCollection|DictionaryItemInterface[]
     */
    public function loadItems($force = false);

    /**
     * @param ArrayCollection|DictionaryItemInterface[] $items
     */
    public function persistItems(ArrayCollection $items);
}
