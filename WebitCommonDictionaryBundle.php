<?php
namespace Webit\Common\DictionaryBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webit\Common\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegisterPass;

class WebitCommonDictionaryBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DictionaryRegisterPass());
    }
}
