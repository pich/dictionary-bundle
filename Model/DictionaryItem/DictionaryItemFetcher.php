<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryProviderInterface;

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
			if($dictionaryItem !== null && !($dictionaryItem instanceof DictionaryItemInterface)) {
			    $cls = get_class($obj);
			    $itemPropertyName = $arRow['itemProperty']->getName();
			    $value = is_scalar($dictionaryItem) ? $dictionaryItem : ('object of '.get_class($dictionaryItem).'class');
			    throw new \Exception(sprintf('Property "%s" of "%s" objet must be instance of DictionaryItemInterface: "%s" given', $itemPropertyName, $cls, $value));
			}
			$value = $dictionaryItem ? $dictionaryItem->getCode() : null;

			$arRow['itemCodeProperty']->setValue($obj, $value);
		}
	}
	
	public function fetchItem($obj) {
		$refClass = new \ReflectionClass(get_class($obj));
		$arProperties = $this->getProperties($refClass);
	
		foreach($arProperties as $arRow) {
			$dictionaryItemValue = $arRow['itemCodeProperty']->getValue($obj);
			if($dictionaryItemValue instanceof DictionaryItemInterface) {
				continue;
			}
			
			if(empty($dictionaryItemValue)) {
				$arRow['itemProperty']->setValue($obj, null);
				continue;
			}
			
			$dict = $this->provider->getDictionary($arRow['dictionaryName']);
			if(!$dict) {
				throw new \Exception('Dictionary named "'.$arRow['dictionaryName'].'" not found.');
			}

			$dictItem = $dict->getItem($dictionaryItemValue);			
			if($dictItem) {
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
				
			$itemProperty = $itemCodeAnnotation->itemProperty ?: $property->getName();
			$dictionaryName = $itemCodeAnnotation->dictionaryName;
			
			$itemProperty = $refClass->getProperty($itemProperty);
			if(!$itemProperty) {
				throw new \Exception('Source property not found');
			}
				
			$property->setAccessible(true);
			$itemProperty->setAccessible(true);
			
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
