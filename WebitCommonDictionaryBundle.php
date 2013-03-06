<?php
namespace Webit\Common\DictionaryBundle;

use Webit\Common\DictionaryBundle\DependencyInjection\Compiler\DictionaryRegisterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class WebitCommonDictionaryBundle extends Bundle
{
	public function build(ContainerBuilder $container) {
		parent::build($container);
		$container->addCompilerPass(new DictionaryRegisterPass());
	}
}
