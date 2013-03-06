<?php
namespace Webit\Common\DictionaryBundle\DependencyInjection\Definition;

use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryConfig;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DictionaryDefinitionHelper {
	/**
   * @var ContainerBuilder
	 */
	protected $container;
	
	/**
   * @var string
	 */
	protected $alias;
	
	public function __construct(ContainerBuilder $container, $alias) {
		$this->container = $container;
		$this->alias = $alias;
	}
	
	/**
	 * @param ContainerBuilder $container
	 * @param array $config
	 * @return Definition
	 */
	public function createDictionaryDefinition(DictionaryConfig $config) {
		$storageDef = $this->createStorageDefinition($config);
		$def = new Definition($config->getDictionaryClass());
			$def->addArgument($storageDef);
			$def->addTag('webit_common_dictionary.dictionary',array('dictionary'=>$config->getName()));
			
		return $def;
	}
	
	/**
	 * @param ContainerBuilder $container
	 * @param array $config
	 */
	public function createStorageDefinition(DictionaryConfig $config) {
		$def = new Definition();
		$def->setFactoryService($config->getStorageFactory());
		$def->setFactoryMethod('createStorage');
		$def->addArgument($config->toArray());
		
		return $def;
	}
	
	public function createDictionaryConfig($dictConfig) {
		$defaults = $this->container->getParameter('webit_common_dictionary.dictionary_defaults');
		$dictConfig = array_replace_recursive($defaults, $dictConfig);
		if(isset($dictConfig['storage_type']) && is_array($dictConfig[$dictConfig['storage_type']])) {
			$dictConfig = array_replace($dictConfig, $dictConfig[$dictConfig['storage_type']]);
			unset($dictConfig[$dictConfig['storage_type']]);
		}
		
		return new DictionaryConfig($dictConfig);
	}
	
	public function registerDefinition(DictionaryConfig $config) {
		$def = $this->createDictionaryDefinition($config);
		$this->container->addDefinitions(array($this->alias.'.'.$config->getName().'_dictionary'=>$def));
	}
}
?>