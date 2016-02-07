<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryProviderInterface
{
    /**
     * @param DictionaryInterface $dictionary
     * @param string $dictionaryName
     */
    public function registerDictionary(DictionaryInterface $dictionary, $dictionaryName);

    /**
     * @param string $dictionaryName
     * @return DictionaryInterface
     */
    public function getDictionary($dictionaryName);

    /**
     * @return DictionaryInterface[]
     */
    public function getDictionaries();
}
