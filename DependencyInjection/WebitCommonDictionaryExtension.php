<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection;

use Webit\Common\DictionaryBundle\DependencyInjection\Definition\DictionaryDefinitionHelper;
use Webit\Common\DictionaryBundle\Model\Dictionary\DictionaryConfig;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WebitCommonDictionaryExtension extends Extension {
	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$loader = new Loader\YamlFileLoader($container,
				new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');
		
		if($config['use_orm_listener']) {
			$def = $container->getDefinition('webit_common_dictionary.dictionary_item_aware_orm_listener');
			$def->addTag('doctrine.event_subscriber');
		}
		
		if($config['use_phpcr_listener']) {
			$def = $container->getDefinition('webit_common_dictionary.dictionary_item_aware_phpcr_listener');
			$def->addTag('doctrine_phpcr.event_subscriber');
		}
		
		if($config['use_serializer_listener']) {
			$def = $container->getDefinition('webit_common_dictionary.dictionary_item_aware_serialization_listener');
			$def->addTag('jms_serializer.event_listener',array('event'=>'serializer.post_deserialize','method'=>'postDeserialize'));
		}
		
		$container->setParameter($this->getAlias().'.dictionary_orm_storage.class',$config['dictionary_defaults']['storage_orm_class']);
			unset($config['dictionary_defaults']['storage_orm_class']);
			
		$container->setParameter($this->getAlias().'.dictionary_phpcr_storage.class',$config['dictionary_defaults']['storage_phpcr_class']);
			unset($config['dictionary_defaults']['storage_phpcr_class']);
		
		$container->setParameter($this->getAlias().'.dictionary_defaults', $config['dictionary_defaults']);
		
		$helper = new DictionaryDefinitionHelper($container, $this->getAlias());
		foreach($config['dictionaries'] as $dict) {
			$dictConfig = $helper->createDictionaryConfig($dict);
			$helper->registerDefinition($dictConfig);
		}
	}
}
?>
