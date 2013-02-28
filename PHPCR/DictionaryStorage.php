<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use Doctrine\ODM\PHPCR\DocumentManager;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;

class DictionaryStorage extends DictionaryCachedStorage {
	/**
   * @var DocumentManager
	 */
	protected $dm;
	
	public function __construct(DocumentManager $dm, $dictionaryName, $itemClass, Cache $cache) {
		parent::__construct($cache, $dictionaryName, $itemClass);
		
		$this->dm = $dm;
		$this->itemClass = $itemClass;
	}
	
	protected function doLoad() {
		$items = $this->dm->getRepository($this->itemClass)->findAll();
		
		return $items;
	} 
	
	/**
	 * @param ArrayCollection $items
	 */
	protected function doPersist(ArrayCollection $items) {
		foreach($items as $item) {
			$this->dm->persist($item);
		}
		
		$this->dm->flush();
	}
}
?>
