<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

class DictionaryProvider implements DictionaryProviderInterface {
	/**
	 * @var array
	 */
	private $dictionaries;
	
	public function registerDictionary($dictionary, $dictionaryName) {
		$this->dictionaries[$dictionaryName] = $dictionary;
	}
	
	public function getDictionary($dictionaryName) {
		if(!isset($this->dictionaries[$dictionaryName])) {
			throw new \Exception('Dictionary named ' . $dictionaryName.' not found.');
		}
		
		return $this->dictionaries[$dictionaryName];
	}
	
	public function getDictionaries() {
		return $this->dictionaries;
	}
}
?>
