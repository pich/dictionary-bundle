<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

class DictionaryProvider implements DictionaryProviderInterface
{
    /**
     * @var DictionaryInterface[]
     */
    private $dictionaries;

    /**
     * @param DictionaryInterface $dictionary
     * @param string $dictionaryName
     */
    public function registerDictionary(DictionaryInterface $dictionary, $dictionaryName)
    {
        $this->dictionaries[$dictionaryName] = $dictionary;
    }

    /**
     * @param string $dictionaryName
     * @return DictionaryInterface
     */
    public function getDictionary($dictionaryName)
    {
        if (!isset($this->dictionaries[$dictionaryName])) {
            throw new \OutOfBoundsException('Dictionary named ' . $dictionaryName . ' not found.');
        }

        return $this->dictionaries[$dictionaryName];
    }

    /**
     * @return DictionaryInterface[]
     */
    public function getDictionaries()
    {
        return $this->dictionaries;
    }
}
