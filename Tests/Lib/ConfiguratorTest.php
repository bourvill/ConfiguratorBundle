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

    public function testGetAllConfigs()
    {
        $this->generateConfig();

        $configurator = new Configurator($this->objectManager);

        $this->assertEquals(array(), $configurator->getConfigs());
    }

    public function testAddConfig()
    {
        $this->generateConfig();
        $configName = $this->faker->word;
        $configs    = array(
            'site_title' => array(
                'type'    => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                'options' => array(
                    'choices'  => array(
                        'Mode 1' => 1,
                    ),
                    'required' => false,
                ),
            ),
        );

        $configurator    = new Configurator($this->objectManager);
        $configInterface = \Mockery::mock('\Dw\Bundle\ConfiguratorBundle\Lib\ConfigInterface');

        $this->assertEquals(array(), $configurator->getConfigs());

        $configInterface->shouldReceive('getName')->once()->andReturn($configName);
        $configInterface->shouldReceive('getConfigs')->once()->andReturn($configs);

        $configurator->addConfig($configInterface);

        $this->assertEquals(array($configName => $configs), $configurator->getConfigs());
    }

    /**
     * @expectedException \Dw\Bundle\ConfiguratorBundle\Lib\UndefinedConfigException
     */
    public function testGetUndefinedConfigs()
    {
        $this->generateConfig();

        $configurator = new Configurator($this->objectManager);

        $this->assertEquals(array(), $configurator->getConfigs('test'));
    }

    public function testGetConfigsWithValidArg()
    {
        $this->generateConfig();
        $configName = $this->faker->word;
        $configs    = array(
            'site_title' => array(
                'type'    => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                'options' => array(
                    'choices'  => array(
                        'Mode 1' => 1,
                    ),
                    'required' => false,
                ),
            ),
        );

        $configurator    = new Configurator($this->objectManager);
        $configInterface = \Mockery::mock('\Dw\Bundle\ConfiguratorBundle\Lib\ConfigInterface');

        $this->assertEquals(array(), $configurator->getConfigs());

        $configInterface->shouldReceive('getName')->once()->andReturn($configName);
        $configInterface->shouldReceive('getConfigs')->once()->andReturn($configs);

        $configurator->addConfig($configInterface);

        $this->assertEquals(array($configs), $configurator->getConfigs($configName));
    }

    /**
     * @expectedException \Dw\Bundle\ConfiguratorBundle\Lib\UndefinedParamException
     */
    public function testGetParamWithInvalidArgument()
    {
        $this->generateConfig();

        $configurator = new Configurator($this->objectManager);

        $configurator->getParam('wrongparam');
    }

    public function testGetParam()
    {
        $this->generateConfig(array('valid_param' => 'data'));

        $configurator = new Configurator($this->objectManager);

        $this->assertEquals('data', $configurator->getParam('valid_param'));
    }

    public function testGet()
    {
        $this->generateConfig(array('valid_param' => 'data'));

        $configurator = new Configurator($this->objectManager);

        $this->assertEquals('data', $configurator->get('valid_param'));
    }

    public function testGetParams()
    {
        $this->generateConfig(array('valid_param' => 'data'));

        $configurator = new Configurator($this->objectManager);

        $this->assertEquals(array('valid_param' => 'data'), $configurator->getParams());
    }

    public function testUpdateWithNoChange()
    {
        $this->generateConfig(array('valid_param' => 'data'));

        $this->objectManager->shouldReceive('createQueryBuilder')->never();
        $configurator = new Configurator($this->objectManager);

        $configurator->update(array('valid_param' => 'data'));
    }

    public function testUpdateApplyChange()
    {
        $this->generateConfig(array('valid_param' => 'data'));

        $qb = \Mockery::mock('Stub');
        $qb->shouldReceive('expr->literal')->once();
        $qb->shouldReceive('update->set->where->setParameter->getQuery->execute')->once();
        $this->objectManager->shouldReceive('createQueryBuilder')->once()->andReturn($qb);
        $this->objectManager->shouldReceive('update');

        $configurator = new Configurator($this->objectManager);

        $configurator->update(array('valid_param' => 'data1'));
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    public function generateConfig($return = array())
    {
        $datas = array();

        foreach ($return as $configParam => $configValue) {
            $mockConfig = \Mockery::mock('Config');
            $mockConfig->shouldReceive('getParam')->andReturn($configParam)->once();
            $mockConfig->shouldReceive('getParamValue')->andReturn($configValue)->once();

            $datas[] = $mockConfig;
        }

        $this->objectManager->shouldReceive('getRepository->findAll')->once()->andReturn($datas);
    }
}
