<?php

namespace Webit\Common\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Daniel Bojdo
 */
class DictionaryRegisterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->registerDictionaries($container);
    }

    private function registerDictionaries(ContainerBuilder $container)
    {
        $provider = $container->getDefinition('webit_common_dictionary.dictionary_provider');
        foreach ($container->findTaggedServiceIds('webit_common_dictionary.dictionary') as $serviceId => $tags) {
            $arTag = array_pop($tags);
            $provider->addMethodCall(
                'registerDictionary',
                array(
                    new Reference($serviceId),
                    $arTag['dictionary']
                )
            );
        }
    }
}
