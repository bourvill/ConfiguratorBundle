<?php

namespace Dw\Bundle\ConfiguratorBundle\Form;

use Dw\Bundle\ConfiguratorBundle\Lib\ConfigInterface;
use Dw\Bundle\ConfiguratorBundle\Lib\Configurator;
use Symfony\Component\Form\FormFactory;

class FormConfigGenerator
{
    /**
     * @var \Dw\Bundle\ConfiguratorBundle\Lib\Configurator
     */
    private $configurator;
    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    private $formFactory;

    public function __construct(Configurator $configurator, FormFactory $formFactory)
    {
        $this->configurator = $configurator;
        $this->formFactory = $formFactory;
    }

    private function build($config_name = null)
    {
        $form = $this->formFactory->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $this->configurator->getParams());

        foreach ($this->configurator->getConfigs($config_name) as $configs) {
            foreach ($configs as $name => $config) {
                $form->add($name, $config['type'], $config['options']);
            }
        }

        return $form;
    }

    public function getForm(ConfigInterface $config = null)
    {
        return $this->build(
                ($config === null) ? null : $config->getName()
            )
            ->getForm();
    }
}
 
