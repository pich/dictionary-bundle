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
        	->arrayNode('dictionary_defaults')->addDefaultsIfNotSet()
        		->children()
        			->scalarNode('dictionary_class')->defaultValue('Webit\Common\DictionaryBundle\Model\Dictionary\Dictionary')->end()
        			->scalarNode('storage_orm_class')->defaultValue('Webit\Common\DictionaryBundle\ORM\DictionaryStorage')->end()
        			->scalarNode('storage_phpcr_class')->defaultValue('Webit\Common\DictionaryBundle\PHPCR\DictionaryStorage')->end()
        			->scalarNode('storage_type')->defaultValue('orm')->end()
        			->scalarNode('storage_factory')->defaultValue('webit_common_dictionary.dictionary_storage_factory')->end()
        			->scalarNode('phpcr_root')->defaultNull()->end()
        		->end()
        	->end()
        	->arrayNode('dictionaries')
        		->prototype('array')->children()
        			->scalarNode('dictionary_class')->end()
        			->scalarNode('dictionary_name')->end()
        			->scalarNode('item_class')->end()
        			->scalarNode('storage_factory')->end()
        			->scalarNode('storage_type')->end()
        			->scalarNode('phpcr_root')->end()
        			->scalarNode('orm_root')->defaultNull()->end()
        	->end()
        ->end();
        
        return $treeBuilder;
    }
}
