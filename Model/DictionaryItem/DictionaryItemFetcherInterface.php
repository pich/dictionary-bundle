<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

interface DictionaryItemFetcherInterface {
	public function fetchItemCode($obj);
	public function fetchItem($obj);
}
?>
