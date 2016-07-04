<?php

namespace Dw\Bundle\ConfiguratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConfiguratorConfigCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $configurator = $container->getDefinition('dw_configurator.configurator');

        foreach ($container->findTaggedServiceIds('dw_configurator.config') as $id => $attributes) {
            $configurator->addMethodCall(
                'addConfig',
                array(
                    new Reference($id),
                )
            );
        }
    }
}
