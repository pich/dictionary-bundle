<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryProviderInterface {
	public function registerDictionary($manager, $dictionaryName);
	
	/**
	 * 
	 * @param string $dictionaryName
	 * @return DictionaryInterface
	 */
	public function getDictionary($dictionaryName);
	
	/**
	 * @return array<DictionaryInterface>
	 */
	public function getDictionaries();
}
?>
