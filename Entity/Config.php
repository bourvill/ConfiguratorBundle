<?php

namespace Dw\Bundle\ConfiguratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration.
 *
 * @ORM\Table(name="dw_config")
 * @ORM\Entity
 */
class Config
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="param", type="string", length=255)
     */
    private $param;

    /**
     * @var string
     *
     * @ORM\Column(name="param_value", type="string", length=255, nullable=true)
     */
    private $paramValue;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set param.
     *
     * @param string $param
     *
     * @return Configuration
     */
    public function setParam($param)
    {
        $this->param = $param;

        return $this;
    }

    /**
     * Get param.
     *
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Set paramValue.
     *
     * @param string $paramValue
     *
     * @return Configuration
     */
    public function setParamValue($paramValue)
    {
        $this->paramValue = $paramValue;

        return $this;
    }

    /**
     * Get paramValue.
     *
     * @return string
     */
    public function getParamValue()
    {
        return $this->paramValue;
    }
}
