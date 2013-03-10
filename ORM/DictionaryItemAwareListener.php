<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Doctrine\Common\EventSubscriber;

use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemFetcher;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAware;

class DictionaryItemAwareListener extends ContainerAware implements EventSubscriber {
	public function getSubscribedEvents() {
		return array(
			'postLoad',
			'prePersist',
			'preUpdate',
		);
	}
	
	/**
	 * 
	 * @return DictionaryItemFetcher
	 */	
	private function getDictionaryItemFetcher() {
		return $this->container->get('webit_common_dictionary.dictionary_item_fetcher');
	}
	
	public function postLoad(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItem($entity);
		}
	}
	
	public function prePersist(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($entity);
		}
	}
	
	public function preUpdate(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($entity);
		}
	}
}
?>
