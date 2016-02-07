<?php
namespace Webit\Common\DictionaryBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryConfig;

class DictionaryDefinitionHelper
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var string
     */
    protected $alias;

    public function __construct(ContainerBuilder $container, $alias)
    {
        $this->container = $container;
        $this->alias = $alias;
    }

    /**
     * @param DictionaryConfig $config
     * @return Definition
     */
    public function createDictionaryDefinition(DictionaryConfig $config)
    {
        $storageDef = $this->createStorageDefinition($config);

        $def = new Definition($config->getDictionaryClass());
        $def->addArgument($storageDef);
        $def->addTag(
            'webit_common_dictionary.dictionary',
            array('dictionary' => $config->getName())
        );

        return $def;
    }

    /**
     * @param DictionaryConfig $config
     * @return Definition
     */
    public function createStorageDefinition(DictionaryConfig $config)
    {
        $def = new Definition();
        $def->setFactory(
            array(
                new Reference('webit_common_dictionary.dictionary_storage_factory'),
                'createStorage'
            )
        );

        $def->addArgument($config->toArray());

        return $def;
    }

    /**
     * @param $dictConfig
     * @return array
     */
    public function mergeConfig(array $dictConfig)
    {
        if (isset($dictConfig['storage_type']) && is_array($dictConfig[$dictConfig['storage_type']])) {
            $dictConfig = array_replace($dictConfig, $dictConfig[$dictConfig['storage_type']]);
            unset($dictConfig[$dictConfig['storage_type']]);
        }

        return $dictConfig;
    }

    /**
     * @param array $dictConfig
     * @return DictionaryConfig
     */
    public function createDictionaryConfig(array $dictConfig)
    {
        $dictConfig = $this->mergeConfig($dictConfig);

        return new DictionaryConfig($dictConfig);
    }

    /**
     * @param DictionaryConfig $config
     */
    public function registerDefinition(DictionaryConfig $config)
    {
        $def = $this->createDictionaryDefinition($config);
        $this->container->addDefinitions(array($this->alias . '.' . $config->getName() . '_dictionary' => $def));
    }
}
