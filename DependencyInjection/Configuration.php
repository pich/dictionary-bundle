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
                ->arrayNode('phpcr')->canBeEnabled()
                    ->children()
                        ->scalarNode('document_manager')->defaultValue('default')->end()
                    ->end()
                ->end()
                ->arrayNode('orm')->canBeEnabled()
                    ->children()
                        ->scalarNode('entity_manager')->defaultValue('default')->end()
                    ->end()
                ->end()
                ->scalarNode('use_serializer_listener')->defaultTrue()->end()
                ->arrayNode('dictionaries')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('dictionary_class')->end()
                            ->scalarNode('dictionary_name')->end()
                            ->scalarNode('item_class')->end()
                            ->scalarNode('storage_type')->end()
                            ->scalarNode('root')->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
