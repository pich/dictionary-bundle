<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerAware;

class DictionaryStorageFactory extends ContainerAware implements DictionaryStorageFactoryInterface {
	/**
	 * @param DictionaryConfig
	 * @return DictionaryStorageInterface
	 */
	public function createStorage(array $config) {
		$arArguments = array();
		switch($config['storageType']) {
			case 'orm':
				$class = $this->container->getParameter('webit_common_dictionary.dictionary_orm_storage.class');
				$arArguments = array(
					$this->container->get('webit_common_dictionary.cache'),
					$this->container->get('doctrine.orm.entity_manager'),
					$config['name'],
					$config['itemClass']							
				);
			break;
			case 'phpcr':
				$class = $this->container->getParameter('webit_common_dictionary.dictionary_phpcr_storage.class');
				$arArguments = array(
						$this->container->get('webit_common_dictionary.cache'),
						$this->container->get('doctrine_phpcr.odm.document_manager'),
						$config['name'],
						$config['itemClass'],
						$config['phpcrRoot']
				);
			break;
		}
		
		$refClass = new \ReflectionClass($class);
		$storage = $refClass->newInstanceArgs($arArguments);
		
		return $storage;
	}
}
?>
