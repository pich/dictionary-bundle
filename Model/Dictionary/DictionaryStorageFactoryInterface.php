<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

interface DictionaryStorageFactoryInterface
{
    /**
     * @param array $config
     * @return DictionaryStorageInterface
     */
    public function createStorage(array $config);
}

