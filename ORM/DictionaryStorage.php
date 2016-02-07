<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryCachedStorage;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemInterface;

class DictionaryStorage extends DictionaryCachedStorage
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $root;

    /**
     * @var string
     */
    protected $rootProperty;

    /**
     * @var string
     */
    protected $codeProperty;

    public function __construct(
        Cache $cache,
        EntityManager $em,
        $dictionaryName,
        $itemClass,
        $codeProperty = 'code',
        $rootProperty = null,
        $root = null
    ) {
        parent::__construct($cache, $dictionaryName, $itemClass);

        $this->em = $em;
        $this->itemClass = $itemClass;

        $this->rootProperty = $rootProperty;
        $this->codeProperty = $codeProperty;
        $this->root = $root;
    }

    /**
     * @param string $code
     * @return DictionaryItemInterface
     */
    protected function doLoadItem($code)
    {
        $params = array($this->codeProperty => $code);
        if ($this->rootProperty) {
            $params[$this->rootProperty] = $this->root;
        }

        return $this->em->getRepository($this->itemClass)->findOneBy($params);
    }

    /**
     * @return DictionaryItemInterface[]
     */
    protected function doLoad()
    {
        if ($this->rootProperty) {
            $items = $this->em->getRepository($this->itemClass)->findBy(array($this->rootProperty => $this->root));
        } else {
            $items = $this->em->getRepository($this->itemClass)->findAll();
        }

        return $items;
    }

    /**
     * @param DictionaryItemInterface[]|ArrayCollection $items
     * @param DictionaryItemInterface[]|ArrayCollection $removed
     */
    protected function doPersist(ArrayCollection $items, ArrayCollection $removed)
    {
        foreach ($removed as $item) {
            $this->em->remove($item);
        }

        foreach ($items as $item) {
            $this->updateRoot($item);
            $this->em->persist($item);
        }
        $this->em->flush();
    }

    /**
     * @param DictionaryItemInterface $item
     * @return DictionaryItemInterface
     */
    private function updateRoot($item)
    {
        if ($this->rootProperty) {
            $refObj = new \ReflectionObject($item);
            $prop = $refObj->getProperty($this->rootProperty);
            $prop->setAccessible(true);
            $prop->setValue($item, $this->root);
            $prop->setAccessible(false);
        }

        return $item;
    }
}
