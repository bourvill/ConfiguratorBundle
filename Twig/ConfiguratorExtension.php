<?php

namespace Dw\Bundle\ConfiguratorBundle\Twig;

use Dw\Bundle\ConfiguratorBundle\Lib\Configurator;

class ConfiguratorExtension extends \Twig_Extension
{
    /**
     * @var \Dw\Bundle\ConfiguratorBundle\Lib\Configurator
     */
    private $configurator;

    public function __construct(Configurator $configurator)
    {
        $this->configurator = $configurator;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('param', array($this, 'getParam')),
        );
    }

    public function getParam($param)
    {
        return $this->configurator->get($param);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'dw_configurator';
    }
}