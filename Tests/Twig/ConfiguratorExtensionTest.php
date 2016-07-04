<?php

namespace Dw\Bundle\ConfiguratorBundle\Tests\Twig;

use Dw\Bundle\ConfiguratorBundle\Twig\ConfiguratorExtension;

class ConfiguratorExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $configurator;
    private $faker;

    public function setUp()
    {
        $this->configurator = $this->prophesize('\Dw\Bundle\ConfiguratorBundle\Lib\Configurator');
        $this->faker        = \Faker\Factory::create();
    }

    public function testGetName()
    {
        $extension = new ConfiguratorExtension($this->configurator->reveal());

        $this->assertEquals('dw_configurator', $extension->getName());
    }

    public function testGetParam()
    {
        $extension = new ConfiguratorExtension($this->configurator->reveal());

        $this->assertNull($extension->getParam($this->faker->word));
    }
}