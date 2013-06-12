<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Annotations\Reader;

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
				$rootProperty = $this->getRootProperty($config['itemClass']);
				$codeProperty = $this->getCodeProperty($config['itemClass']);

				$arArguments = array(
					$this->container->get('webit_common_dictionary.cache'),
					$this->container->get('doctrine.orm.entity_manager'),
					$config['name'],
					$config['itemClass'],
					$codeProperty,
					$rootProperty,
					$config['ormRoot']						
				);
			break;
			case 'phpcr':
				$class = $this->container->getParameter('webit_common_dictionary.dictionary_phpcr_storage.class');
				$codeProperty = $this->getCodeProperty($config['itemClass']);
				$arArguments = array(
						$this->container->get('webit_common_dictionary.cache'),
						$this->container->get('doctrine_phpcr.odm.document_manager'),
						$config['name'],
						$config['itemClass'],
						$config['phpcrRoot'],
						$codeProperty
				);
			break;
		}
		
		$refClass = new \ReflectionClass($class);
		$storage = $refClass->newInstanceArgs($arArguments);
		
		return $storage;
	}
	
	/**
	 * 
	 * @return Reader
	 */
	private function getAnnotationReader() {
		$reader = $this->container->get('annotation_reader');
		
		return $reader;
	}
	
	private function getRootProperty($itemClass) {
		$annotationName = 'Webit\Common\DictionaryBundle\Annotation\ItemRoot';
		$refClass = new \ReflectionClass($itemClass);
		$reader = $this->getAnnotationReader();
		
		foreach($refClass->getProperties() as $name=>$property) {
			$itemCodeAnnotation = $reader->getPropertyAnnotation($property, $annotationName);
			if($itemCodeAnnotation) {
				return $property->getName();
			}
		}
		
		return null;
	}
	
	private function getCodeProperty($itemClass) {
		$annotationName = 'Webit\Common\DictionaryBundle\Annotation\ItemCode';
		$refClass = new \ReflectionClass($itemClass);
		$reader = $this->getAnnotationReader();
		
		foreach($refClass->getProperties() as $name=>$property) {
			$itemCodeAnnotation = $reader->getPropertyAnnotation($property, $annotationName);
			if($itemCodeAnnotation) {
				return $property->getName();
			}
		}
		
		if($refClass->hasProperty('code')) {
			return 'code';
		}
		
		if($refClass->hasProperty('id')) {
			return 'id';
		}
		
		return null;
	}
}
?>
