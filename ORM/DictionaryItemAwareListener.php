<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemFetcher;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAware;

class DictionaryItemAwareListener extends ContainerAware implements EventSubscriberInterface {
	static public function getSubscribedEvents() {
		return array(
			'postLoad' => array('onPostLoad'),
			'prePersist' => array('onPrePersist'),
			'preUpdate' => array('onPreUpdate'),
		);
	}
	
	/**
	 * 
	 * @return DictionaryItemFetcher
	 */	
	private function getDictionaryItemFetcher() {
		return $this->container->get('webit_common_dictionary.dictionary_item_fetcher');
	}
	
	public function onPostLoad(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItem($doc);
		}
	}
	
	public function onPrePersist(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
	
	public function onPreUpdate(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
}
?>
