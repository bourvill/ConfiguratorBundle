<?php

namespace Dw\Bundle\ConfiguratorBundle\Lib;

class Config2 implements ConfigInterface
{
    public function getConfigs()
    {
        return array(
            'site_title2' => array(
                'type' => 'text',
                'options' => array(
                    'required' => false
                )
            ),
            'site_description2' => array(
                'type' => 'textarea',
                'options' => array(
                    'required' => true,
                )
            )
        );
    }

    public function getName()
    {
        return 'config_sample2';
    }
}
 