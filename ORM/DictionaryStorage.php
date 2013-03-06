<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Cache\Cache;

use Doctrine\ORM\EntityManager;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;

class DictionaryStorage extends DictionaryCachedStorage {
	/**
   * @var EntityManager
	 */
	protected $em;
	
	public function __construct(Cache $cache, EntityManager $em, $dictionaryName, $itemClass) {
		parent::__construct($cache, $dictionaryName, $itemClass);
		
		$this->em = $em;
		$this->itemClass = $itemClass;
	}
	
	protected function doLoadItem($code) {
		return $this->em->getRepository($this->itemClass)->findOneBy(array('code'=>$code));
	}
	
	protected function doLoad() {
		$items = $this->em->getRepository($this->itemClass)->findAll();
		
		return $items;
	} 
	
	/**
	 * @param ArrayCollection $items
	 */
	protected function doPersist(ArrayCollection $items, ArrayCollection $removed) {
		foreach($removed as $item) {
			$this->em->remove($item);
		}
		
		foreach($items as $item) {
			$this->em->persist($item);
		}
		$this->em->flush();
	}
}
?>
