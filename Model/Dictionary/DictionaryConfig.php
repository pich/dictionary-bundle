<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

class DictionaryConfig
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $dictionaryClass;

    /**
     * @var string
     */
    protected $itemClass;

    /**
     * @var string
     */
    protected $storageType = 'orm';

    /**
     * @var string
     */
    protected $root;

    /**
     * DictionaryConfig constructor.
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->fromArray($config);
    }

    /**
     * @param $config
     */
    private function fromArray($config)
    {
        $this->dictionaryClass = isset($config['dictionary_class']) && $config['dictionary_class'] ? $config['dictionary_class'] : 'Webit\Common\DictionaryBundle\Model\Dictionary\Dictionary';
        $this->name = $config['dictionary_name'];
        $this->itemClass = $config['item_class'];
        $this->storageType = $config['storage_type'];
        $this->root = $config['root'];

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getItemClass()
    {
        return $this->itemClass;
    }

    /**
     * @param string $itemClass
     */
    public function setItemClass($itemClass)
    {
        $this->itemClass = $itemClass;
    }

    /**
     * @return string
     */
    public function getStorageType()
    {
        return $this->storageType;
    }

    /**
     * @param string $storageType
     */
    public function setStorageType($storageType)
    {
        $this->storageType = $storageType;
    }

    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $dictionaryClass
     */
    public function setDictionaryClass($dictionaryClass)
    {
        $this->dictionaryClass = $dictionaryClass;
    }

    /**
     * @return string
     */
    public function getDictionaryClass()
    {
        return $this->dictionaryClass;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
