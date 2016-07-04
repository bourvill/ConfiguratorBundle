<?php

namespace Dw\Bundle\ConfiguratorBundle\Command;

use Dw\Bundle\ConfiguratorBundle\Entity\Config;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('dw:configurator:build-db')
            ->setDescription('Executes the SQL needed to update the config table to match the current mapping configurator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurator = $this->getContainer()->get('dw_configurator.configurator');
        $objectManager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $change = 0;
        foreach ($configurator->getConfigs() as $configs) {
            foreach ($configs as $paramName => $config) {
                $param = $objectManager->getRepository('DwConfiguratorBundle:Config')
                    ->findOneBy(array('param' => $paramName));

                if (!$param) {
                    ++$change;

                    $output->writeln(sprintf('Create "%s"', $paramName));

                    $newParam = new Config();
                    $newParam->setParam($paramName);

                    $objectManager->persist($newParam);
                }
            }
        }

        if (!$change) {
            $output->writeln('Nothing to update - your database is already in sync with the current configurator.');
        }

        $objectManager->flush();
    }
}
