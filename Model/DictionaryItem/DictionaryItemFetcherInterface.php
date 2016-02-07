<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

interface DictionaryItemFetcherInterface
{
    /**
     * @param mixed $obj
     */
    public function fetchItemCode($obj);

    /**
     * @param mixed $obj
     */
    public function fetchItem($obj);
}
