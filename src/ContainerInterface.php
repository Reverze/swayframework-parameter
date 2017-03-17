<?php

namespace Sway\Component\Parameter;

class ContainerInterface
{
    /**
     * Parameter's container
     * @var \Sway\Component\Parameter\Container
     */
    private $container = null;
    
    public function __construct(Container $parameterContainer)
    {
        /**
         * If parameter's container is empty
         */
        if (empty($this->container)){
            $this->container = $parameterContainer;
        }
        
    }
    
    /**
     * Gets parameter's value
     * @param string $parameterPath
     * @return mixed
     */
    public function get(string $parameterPath)
    {
        return $this->container->get($parameterPath);
    }
    
}


?>