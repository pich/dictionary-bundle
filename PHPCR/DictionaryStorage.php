<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Util\NodeHelper;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

class DictionaryStorage extends DictionaryCachedStorage
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var Generic
     */
    protected $dictRoot;

    /**
     * @var string
     */
    protected $codeProperty;

    public function __construct(
        Cache $cache,
        DocumentManager $dm,
        $dictionaryName,
        $itemClass,
        $dictRoot,
        $codeProperty = 'code'
    ) {
        parent::__construct($cache, $dictionaryName, $itemClass);

        $this->dm = $dm;
        $this->codeProperty = $codeProperty;
        $this->dictRoot = $dictRoot;
    }

    private function setDictRoot($dictRoot)
    {
        if ($dictRoot) {
            if ($root = $this->dm->find(null, $dictRoot)) {
                $this->dictRoot = $root;
            } else {
                NodeHelper::createPath($this->dm->getPhpcrSession(), $dictRoot);
                $this->setDictRoot($dictRoot);
            }
        }
    }

    private function getDictRoot()
    {
        if (is_string($this->dictRoot)) {
            $this->setDictRoot($this->dictRoot);
        }

        return $this->dictRoot;
    }

    protected function doLoadItem($code)
    {
        return $this->dm->getRepository($this->itemClass)->findOneBy(array($this->codeProperty => $code));
    }

    /**
     * @return array|DictionaryItemInterface[]
     */
    protected function doLoad()
    {
        $items = $this->dm->getRepository($this->itemClass)->findAll();

        return $items;
    }

    /**
     * @param ArrayCollection $items
     * @param ArrayCollection $removed
     */
    protected function doPersist(ArrayCollection $items, ArrayCollection $removed)
    {
        foreach ($removed as $item) {
            $this->dm->remove($item);
        }

        foreach ($items as $item) {
            if ($item->getId() == null) {
                $item->setNodename($item->getCode());
                $item->setParent($this->getDictRoot());
            }

            $this->dm->persist($item);
        }

        $this->dm->flush();
    }
}
