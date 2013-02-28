<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webit_common_dictionary');
        
        $rootNode
        ->children()
        	->scalarNode('use_orm_listener')->defaultTrue()->end()
        	->scalarNode('use_phpcr_listener')->defaultTrue()->end()
        	->scalarNode('use_serializer_listener')->defaultTrue()->end()
        	->scalarNode('dictionary_class')->defaultValue('Webit\Common\DictionaryBundle\Model\Dictionary\Dictionary')->end()
        	->arrayNode('dictionary_defaults')->addDefaultsIfNotSet()
        		->children()
        			->scalarNode('storage_type')->defaultValue('orm')->end()
        			->scalarNode('dictionary')->defaultValue('webit_common_dictionary.dictionary')->end()
        			->scalarNode('orm_storage')->defaultValue('webit_common_dictionary.dictionary_orm_storage')->end()
        			->scalarNode('phpcr_storage')->defaultValue('webit_common_dictionary.dictionary_phpcr_storage')->end()
        		->end()
        	->end()
        	->arrayNode('dictionaries')
        		->prototype('array')
        			->scalarNode('dictionary_name')->end()
        			->scalarNode('item_class')->end()
        			->scalarNode('dictionary')->defaultNull()->end()
        			->scalarNode('storage_type')->defaultNull()->end()
        	->end()
        ->end();
        
        return $treeBuilder;
    }
}
