<?php

namespace Dw\Bundle\ConfiguratorBundle\Tests\Lib;

use Dw\Bundle\ConfiguratorBundle\Lib\Configurator;

class ConfiguratorTest extends \PHPUnit_Framework_TestCase
{
    private $faker;
    private $objectManager;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();

        $this->objectManager = \Mockery::mock('\Doctrine\Common\Persistence\ObjectManager');
    }

    public function testAddConfig()
    {
        $this->generateConfig();
        $configName = $this->faker->word;
        $configs = array(
            'site_title' => array(
                'type' => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                'options' => array(
                    'choices' => array(
                        'Mode 1' => 1,
                    ),
                    'required' => false,
                ),
            ),
        );

        $configurator = new Configurator($this->objectManager);
        $configInterface = \Mockery::mock('\Dw\Bundle\ConfiguratorBundle\Lib\ConfigInterface');

        $this->assertEquals(array(), $configurator->getConfigs());

        $configInterface->shouldReceive('getName')->once()->andReturn($configName);
        $configInterface->shouldReceive('getConfigs')->once()->andReturn($configs);

        $configurator->addConfig($configInterface);

        $this->assertEquals(array($configName => $configs), $configurator->getConfigs());
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    public function generateConfig($return = array())
    {
        $this->objectManager->shouldReceive('getRepository->findAll')->once()->andReturn($return);
    }
}
