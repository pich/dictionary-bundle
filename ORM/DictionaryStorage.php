<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Doctrine\ORM\EntityManager;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;

class DictionaryStorage extends DictionaryCachedStorage {
	/**
   * @var EntityManager
	 */
	protected $em;
	
	public function __construct(EntityManager $em, $dictionaryName, $itemClass, Cache $cache) {
		parent::__construct($cache, $dictionaryName, $itemClass);
		
		$this->em = $em;
		$this->itemClass = $itemClass;
	}
	
	protected function doLoad() {
		$items = $this->em->getRepository($this->itemClass)->findAll();
		
		return $items;
	} 
	
	/**
	 * @param ArrayCollection $items
	 */
	protected function doPersist(ArrayCollection $items) {
		foreach($items as $item) {
			$this->em->persist($item);
		}
		
		$this->em->flush();
	}
}
?>
