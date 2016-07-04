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
        $this->faker = \Faker\Factory::create();
    }

    public function testGetName()
    {
        $extension = new ConfiguratorExtension($this->configurator->reveal());

        $this->assertEquals('dw_configurator', $extension->getName());
    }

    public function testGetFunctions()
    {
        $extension = new ConfiguratorExtension($this->configurator->reveal());

        $functions = $extension->getFunctions();
        $this->assertEquals(1, count($functions));

        $functionParam = $functions[0];
        $functionParamCallable = $functionParam->getCallable();

        $this->assertEquals('param', $functionParam->getName());
        $this->assertEquals(get_class($extension), get_class($functionParamCallable[0]));
        $this->assertEquals('getParam', $functionParamCallable[1]);
    }

    public function testGetParam()
    {
        $extension = new ConfiguratorExtension($this->configurator->reveal());

        $this->assertNull($extension->getParam($this->faker->word));
    }
}
