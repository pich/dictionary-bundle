<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Webit\Common\DictionaryBundle\DependencyInjection\Definition\DictionaryDefinitionHelper;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WebitCommonDictionaryExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('common.xml');

        if ($config['phpcr']['enabled']) {
            $documentManager = new Definition('Doctrine\ORM\EntityManager');
            $documentManager->setFactory(
                array(new Reference('doctrine_phpcr'), 'getManager')
            );
            $documentManager->addArgument('webit_common_dictionary.phpcr.document_manager');
            $container->setDefinition('webit_common_dictionary.phpcr.document_manager', $documentManager);

            $loader->load('phpcr.xml');
        }

        if ($config['orm']['enabled']) {
            $entityManager = new Definition('Doctrine\ORM\EntityManager');
            $entityManager->setFactory(
                array(new Reference('doctrine'), 'getManager')
            );
            $entityManager->addArgument($config['orm']['entity_manager']);
            $container->setDefinition('webit_common_dictionary.orm.entity_manager', $entityManager);

            $loader->load('orm.xml');
        }

        if ($container['use_serializer_listener']) {
            $loader->load('jms_serializer.xml');
        }

        $container->setParameter($this->getAlias() . '.dictionary_defaults', $config['dictionary_defaults']);

        $helper = new DictionaryDefinitionHelper($container, $this->getAlias());
        foreach ($config['dictionaries'] as $dict) {
            $dictConfig = $helper->createDictionaryConfig($dict);
            $helper->registerDefinition($dictConfig);
        }
    }
}
