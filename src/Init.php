<?php

namespace Sway\Component\Parameter;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Init\Component;

class Init extends Component
{
    /**
     * Array which contains defined parameters
     * @var array
     */
    private $parameters = array();
    
    protected function dependencyController() 
    {
        if ($this->getDependency('framework')->hasCfg('framework/parameter')){
            $this->parameters = $this->getDependency('framework')->getCfg('framework/parameter');
        }
    }
    
    /**
     * 
     * @return \Sway\Component\Parameter\Container
     */
    public function init()
    {
        $parameterContainer = Container::createFromList($this->parameters);
        return $parameterContainer;
    }
}

?>

