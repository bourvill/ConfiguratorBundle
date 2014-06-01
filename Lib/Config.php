<?php

namespace Dw\Bundle\ConfiguratorBundle\Lib;

class Config implements ConfigInterface
{
    public function getConfigs()
    {
        return array(
            'site_title' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false
                )
            ),
            'site_description' => array(
                'type' => 'textarea',
                'options' => array(
                    'required' => true,
                )
            )
        );
    }

    public function getName()
    {
        return 'config_sample';
    }
}
 