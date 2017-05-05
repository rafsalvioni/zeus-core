<?php

namespace Zeus\Core\Config;

/**
 * Trait to implement Zeus\Core\ObjectAccess using configurable objects.
 *
 * @author Rafael M. Salvioni
 */
trait ObjectAccessTrait
{
    use ConfigurableTrait;
    
    /**
     * 
     * @param string $var
     * @param mixed $value
     */
    public function __set(string $var, $value)
    {
        $this->getConfig()->set($var, $value);
    }
    
    /**
     * 
     * @param string $var
     * @return mixed
     */
    public function __get(string $var)
    {
        return $this->getConfig()->get($var);
    }
    
    /**
     * 
     * @param string $var
     * @return bool
     */
    public function __isset(string $var): bool
    {
        return $this->getConfig()->has($var);
    }
    
    /**
     * 
     * @param string $var
     */
    public function __unset(string $var)
    {
    }
}
