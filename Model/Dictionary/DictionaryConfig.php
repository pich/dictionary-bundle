<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;
class DictionaryConfig {
	protected $name;

	protected $dictionaryClass;
	
	protected $itemClass;

	protected $storageType = 'orm';

	protected $storageFactory;

	protected $phpcrRoot;
	
	public function __construct(array $config = array()) {
		$this->fromArray($config);
	}

	private function fromArray($config) {
		$this->dictionaryClass = $config['dictionary_class'];
		$this->name = $config['dictionary_name'];
		$this->itemClass = $config['item_class'];
		$this->storageType = $config['storage_type'];
		$this->storageFactory = $config['storage_factory'];
		$this->phpcrRoot = $config['phpcr_root'];
	}
	
	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getItemClass() {
		return $this->itemClass;
	}

	public function setItemClass($itemClass) {
		$this->itemClass = $itemClass;
	}

	public function getStorageType() {
		return $this->storageType;
	}

	public function setStorageType($storageType) {
		$this->storageType = $storageType;
	}

	public function getStorageFactory() {
		return $this->storageFactory;
	}

	public function setStorageFactory($storageFactory) {
		$this->storageFactory = $storageFactory;
	}

	public function getPhpcrRoot() {
		return $this->phpcrRoot;
	}

	public function setPhpcrRoot($phpcrRoot) {
		$this->phpcrRoot = $phpcrRoot;
	}
	
	public function setDictionaryClass($dictionaryClass) {
		$this->dictionaryClass = $dictionaryClass;
	}
	
	public function getDictionaryClass() {
		return $this->dictionaryClass;
	}
	
	public function toArray() {
		return get_object_vars($this);
	}
}
?>