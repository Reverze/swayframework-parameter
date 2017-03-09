<?php

namespace Sway\Component\Parameter;

use Sway\Component\Parameter\Exception;


class Container
{
    /**
     * Array which contains parameters
     * @var string
     */
    private $parameters = array();
    
    public function __construct() 
    {
        
    }
    
    public function unboxParametersList(array $parametersList)
    {
        /**
         * Parameter's value can be string, numeric, array
         */
        $this->parameters = $parametersList;
    }
    
    /**
     * Creates a new parameter's container using parameters list
     * @param array $parametersList
     * @return \Sway\Component\Parameter\Container
     */
    public static function createFromList(array $parametersList)
    {
        
        $parameterContainer = new Container();
        $parameterContainer->unboxParametersList($parametersList);
        return $parameterContainer;
    }
    
    /**
     * Adds parameter into container
     * @param string $parameterName Parameter's name
     * @param mixed $parameterValue Parameter's value
     */
    public function addParameter(string $parameterName, $parameterValue)
    {
        $this->parameters[$parameterName] = $parameterValue;
    }
    
    /**
     * Removes parameter from container
     * @param string $parameterName Parameter's name
     */
    public function removeParameter(string $parameterName)
    {
        if (isset($this->parameters[$parameterName])){
            unset($this->parameters[$parameterName]);
        }
    }
    
    /**
     * Checks if container has specified parameter
     * @param string $parameterName Parameter's name
     * @return boolean
     */
    public function hasParameter(string $parameterName) : bool
    {
        return isset($this->parameters[$parameterName]);
    }
    
    public function get(string $parameterPath)
    {
        
        /**
         * Explode parameter path into single keys array
         */
        $explodedPath = explode (".", $parameterPath);
        
        /**
         * First key is potential first array
         * @var $parameterName string
         */
        $parameterName = (string) $explodedPath[0];
        
        
        //var_dump($this->parameters);
        if (isset($this->parameters[$parameterName])){
            $currentContext = $this->parameters[$parameterName];
            
            $contextNameBuilder = $parameterName;
            
            for ($call = 1; $call < sizeof($explodedPath); $call++){
                $parameterSubname = $explodedPath[$call];
                $contextNameBuilder .= sprintf(".%s", $parameterSubname);
                
                if (isset($currentContext[$parameterSubname])){
                    $currentContext = $currentContext[$parameterSubname];
                }
                else{
                     throw Exception\ParameterException::parameterNotFoundException($contextNameBuilder);   
                }
                
            }
            
            /**
             * Searchs for calls to another parameter
             */
            if (is_string($currentContext)){
                $matchesArray = array();
                if (preg_match('/^%([a-zA-Z0-9\_\-\.]+)%$/', $currentContext, $matchesArray)){
                    $parameterName = $matchesArray[1] ?? null;
                    if (!empty($parameterName)){
                        $currentContext = $this->get($parameterName);
                    }
                }
            }
            
            return $currentContext;
            
        }
        else{
            throw Exception\ParameterException::parameterNotFoundException($parameterName);
        }
    }
}


?>

