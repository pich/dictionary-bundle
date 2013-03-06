<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * @author Daniel Bojdo
 */
class DictionaryRegisterPass implements CompilerPassInterface {
	public function process(ContainerBuilder $container) {
		$this->registerDictionaries($container);
	}
	
	private function registerDictionaries(ContainerBuilder $container) {
		$provider = $container->getDefinition('webit_common_dictionary.dictionary_provider');
		foreach($container->getDefinitions() as $def) {
			if($def->hasTag('webit_common_dictionary.dictionary')) {
				$arTags = $def->getTag('webit_common_dictionary.dictionary');
				$arTag = array_pop($arTags);
				$provider->addMethodCall('registerDictionary',array($def,$arTag['dictionary']));
			}
		}
	}
}
?>
