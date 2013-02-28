<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\Definition;

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

		$storageConfig = $config[$config['storage']];
		foreach ($storageConfig as $key => $value) {
			$container->setParameter($this->getAlias() . '.' . $key, $value);
		}
		$loader->load($config['storage'] . '.yml');

		$loaderDef = $container->getDefinition('webit_common_unit.unit_loader');
		$loaderDef
				->addArgument($container->getParameter('webit_common_unit.unit_class'));

		$managerDef = $container->getDefinition('webit_common_unit.unit_manager');
		$managerDef
				->addArgument($container->getParameter('webit_common_unit.unit_class'));

		$loader->load('services.yml');
		
		if($config['use_extjs']) {
			$loader->load('extjs.yml');
		}
	}
	
	private function createDictionaries($dictionaries, $defaults) {
		foreach($dictionaries as $dictionaryConfig) {
			$definition = new Definition($dictionaryConfig['dictionary_class'],array($));
			$defi
		}
	}
}
?>
