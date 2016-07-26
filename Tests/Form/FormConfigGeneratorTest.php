<?php

namespace Dw\Bundle\ConfiguratorBundle\Tests\Form;

use Dw\Bundle\ConfiguratorBundle\Form\FormConfigGenerator;

class FormConfigGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetForm()
    {
        $formGenerator = new FormConfigGenerator($this->getMockConfigurator(), $this->getMockFormBuilder());
        $this->assertEquals('success', $formGenerator->getForm());
    }

    private function getMockConfigurator()
    {
        $configurator = \Mockery::mock('\Dw\Bundle\ConfiguratorBundle\Lib\Configurator');
        $configurator->shouldReceive('getParams');
        $configurator->shouldReceive('getConfigs')->andReturn(array());

        return $configurator;
    }

    private function getMockFormBuilder()
    {
        $form = \Mockery::mock('Builder');
        $form->shouldReceive('getForm')->once()->andReturn('success');
        $formBuilder = \Mockery::mock('\Symfony\Component\Form\FormFactory');
        $formBuilder->shouldReceive('createBuilder')->with(
            'Symfony\Component\Form\Extension\Core\Type\FormType',
            \Mockery::any()
        )->andReturn($form);

        return $formBuilder;
    }

    protected function tearDown()
    {
        \Mockery::close();
    }
}
