<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use Doctrine\Common\EventSubscriber;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryFetcherInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;


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
		$doc = $args->getDocument();
		if($doc instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItem($doc);
		}
	}
	
	public function prePersist(LifecycleEventArgs $args) {
		$doc = $args->getDocument();
		if($doc instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
	
	public function preUpdate(LifecycleEventArgs $args) {
		$doc = $args->getDocument();
		if($doc instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
}
?>
