<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use PHPCR\Util\NodeHelper;
use Doctrine\Common\Cache\Cache;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ODM\PHPCR\DocumentManager;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;

class DictionaryStorage extends DictionaryCachedStorage {
	/**
   * @var DocumentManager
	 */
	protected $dm;
	
	/**
	 * @var Generic
	 */
	protected $dictRoot;
	
	public function __construct(Cache $cache, DocumentManager $dm, $dictionaryName, $itemClass, $dictRoot) {
		parent::__construct($cache, $dictionaryName, $itemClass);
		
		$this->dm = $dm;
		$this->setDictRoot($dictRoot);
	}
	
	private function setDictRoot($dictRoot) {
		if($dictRoot) {
			if($root = $this->dm->find(null, $dictRoot)) {
				$this->dictRoot = $root;
			} else {
				NodeHelper::createPath($this->dm->getPhpcrSession(),$dictRoot);
				$this->setDictRoot($dictRoot);
			}
		}
	}
	
	protected function doLoadItem($code) {
		return $this->dm->getRepository($this->itemClass)->findOneBy(array('code'=>$code));
	}
	
	protected function doLoad() {
		$items = $this->dm->getRepository($this->itemClass)->findAll();
		
		return $items;
	} 
	
	/**
	 * @param ArrayCollection $items
	 */
	protected function doPersist(ArrayCollection $items, ArrayCollection $removed) {
		foreach($removed as $item) {
			$this->dm->remove($item);
		}
		
		foreach($items as $item) {
			if($item->getId() == null) {
				$item->setNodename($item->getCode());
				$item->setParent($this->dictRoot);
			}
			
			$this->dm->persist($item);
		}
		
		$this->dm->flush();
	}
}
?>
