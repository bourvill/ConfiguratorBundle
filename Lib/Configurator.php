<?php

namespace Dw\Bundle\ConfiguratorBundle\Lib;

use Doctrine\Common\Persistence\ObjectManager;

class Configurator
{
    private $loaded = false;
    private $configs = array();

    private $dataConfigs = array();
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    private function loadData()
    {
        $configs = $this->objectManager->getRepository('DwConfiguratorBundle:Config')
            ->findAll();

        foreach ($configs as $config) {
            $this->dataConfigs[$config->getParam()] = $config->getParamValue();
        }
    }

    public function addConfig(ConfigInterface $config)
    {
        $this->configs[$config->getName()] = $config->getConfigs();
    }

    public function getConfigs($config_name = null)
    {
        if ($config_name === null) {
            return $this->configs;
        }

        if (!isset($this->configs[$config_name])) {
            throw new UndefinedConfigException(sprintf('Config "%s" doesn\'t exist', $config_name));
        }

        return array(
            $this->configs[$config_name],
        );
    }

    public function getParam($param)
    {
        $loadedParams = $this->getParams();
        if (!array_key_exists($param, $loadedParams)) {
            throw new UndefinedParamException(sprintf('Param "%s" doesn\'t exist', $param));
        }

        return $loadedParams[$param];
    }

    public function getParams()
    {
        if(false === $this->loaded) {
            $this->loadData();
            $this->loaded = true;
        }
        return $this->dataConfigs;
    }

    public function get($param)
    {
        return $this->getParam($param);
    }

    public function update($formData)
    {
        $loadedParams = $this->getParams();
        foreach (array_diff($formData, $loadedParams) as $param => $param_value) {
            $this->updateParam($param, $param_value);
        }
    }

    private function updateParam($key, $value)
    {
        $qb = $this->objectManager->createQueryBuilder();

        $qb->update('DwConfiguratorBundle:Config', 'c')
            ->set('c.paramValue', $qb->expr()->literal($value))
            ->where('c.param = :param')
            ->setParameter('param', $key)
            ->getQuery()
            ->execute();
    }
}
