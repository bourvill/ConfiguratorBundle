<?php

namespace Dw\Bundle\ConfiguratorBundle\Tests\Entity;

use Dw\Bundle\ConfiguratorBundle\Entity\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $faker;

    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function testId()
    {
        $config = new Config();

        $this->assertNull($config->getId());
    }

    public function testParam()
    {
        $config = new Config();

        $paramName = $this->faker->word;

        $this->assertNull($config->getParam());
        $config->setParam($paramName);

        $this->assertEquals($paramName, $config->getParam());
    }

    public function testParamValue()
    {
        $config = new Config();

        $paramValue = $this->faker->word;

        $this->assertNull($config->getParamValue());
        $config->setParamValue($paramValue);

        $this->assertEquals($paramValue, $config->getParamValue());
    }
}
