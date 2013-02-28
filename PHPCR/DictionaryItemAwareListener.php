<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Webit\Common\DictionaryBundle\Model\DictionaryAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryFetcherInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;


class DictionaryListener extends ContainerAware implements EventSubscriberInterface {
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
	
	public function postLoad(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItem($doc);
		}
	}
	
	public function prePersist(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
	
	public function preUpdate(LifecycleEventArgs $args) {
		$entity = $args->getEntity();
		if($entity instanceof DictionaryItemAwareInterface) {
			$this->getDictionaryItemFetcher()->fetchItemCode($doc);
		}
	}
}
?>
