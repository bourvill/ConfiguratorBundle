<?php

namespace Dw\Bundle\ConfiguratorBundle;

use Dw\Bundle\ConfiguratorBundle\DependencyInjection\Compiler\ConfiguratorConfigCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DwConfiguratorBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
        $builder->addCompilerPass(new ConfiguratorConfigCompilerPass());
    }
}
