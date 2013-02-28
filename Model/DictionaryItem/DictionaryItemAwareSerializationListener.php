<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

use Webit\Common\DictionaryBundle\Model\DictionaryAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryFetcherInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use JMS\Serializer\EventDispatcher\Event;

class DictionaryItemAwareSerializationListener extends ContainerAware {
	private function getDictionaryItemFetcher() {
		return $this->container->get('webit_common_dictionary.dictionary_item_fetcher');
	}
	
	public function postDeserialize(Event $event) {
		$doc = $event->getObject(); // TODO: probably change to getContex
		if($doc instanceof DictionaryAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItem($doc);
		}
	}
}
?>
