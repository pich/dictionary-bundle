<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

use Doctrine\Common\Annotations\Reader;

class DictionaryItemFetcher {
	/**
	 * @var DictionaryProviderInterface
	 */
	private $provider;
	
	/**
	 * @var Reader
	 */
	private $reader;
	
	public function __construct(DictionaryProviderInterface $dictionaryProvider, Reader $reader) {
		$this->provider = $dictionaryProvider;
		$this->reader = $reader;
	}
	
	public function fetchItemCode($obj) {
		$refClass = new \ReflectionClass(get_class($obj));
		$arProperties = $this->getProperties($refClass);
		foreach($arProperties as $arRow) {
			$dictionaryItem = $arRow['itemProperty']->getValue($obj);
			$arRow['itemCodeProperty']->setValue($obj, $dictionaryItem ? $dictionaryItem->getCode() : null);
		}
	}
	
	public function fetchItem($obj) {
		$refClass = new \ReflectionClass(get_class($obj));
		$arProperties = $this->getProperties($refClass);
	
		foreach($arProperties as $arRow) {
			$dictionaryItemValue = $arRow['itemCodeProperty']->getValue($obj);
			if(empty($dictionaryItemValue)) {
				$arRow['itemProperty']->setValue($obj, null);
				continue;
			}
			
			$dict = $this->provider->getDictionary($arRow['dictionaryName']);
			if(!$dict) {
				throw new \Exception('Dictionary named "'.$arRow['dictionaryName'].'" not found.');
			}

			$dictItem = $dict->getItem($dictionaryItemValue);
			if($dictionaryItem) {
				$arRow['itemProperty']->setValue($obj, $dictItem);
			}
		}
	}
	
	private function getProperties(\ReflectionClass $refClass) {
		$annotationName = 'Webit\Common\DictionaryBundle\Annotation\ItemCode';
	
		$arProperties = array();
		foreach($refClass->getProperties() as $property) {
			$itemCodeAnnotation = $this->reader->getPropertyAnnotation($property, $annotationName);
			if(!$itemCodeAnnotation) {
				continue;
			}
				
			$itemProperty = $itemCodeAnnotation->itemProperty;
			$dictionaryName = $itemCodeAnnotation->dictionaryName;
			
			$itemProperty = $refClass->getProperty($itemProperty);
			if(!$dictionaryItemProperty) {
				throw new \Exception('Source property not found');
			}
				
			$property->setAccessible(true);
			$dictionaryItemProperty->setAccessible(true);
			
			$arRow = array();
			$arRow['itemCodeProperty'] = $property;
			$arRow['itemProperty'] = $itemProperty;
			$arRow['dictionaryName'] = $dictionaryName;
			
			$arProperties[] = $arRow;
		}
	
		return $arProperties;
	}
}
?>
