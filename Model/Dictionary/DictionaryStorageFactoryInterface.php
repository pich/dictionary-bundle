<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryStorageFactoryInterface {
	/**
	 * @param DictionaryConfig $config
	 * @return DictionaryStorageInterface
	 */
	public function createStorage(array $config);
}
?>
