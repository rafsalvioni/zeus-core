<?php

namespace Zeus\Core;

/**
 * Interface to provides object access using magic methods.
 * 
 * @author Rafael M. Salvioni
 */
interface ObjectAccess
{
    /**
     * 
     * @param string $var
     * @param mixed $value
     */
    public function __set(string $var, $value);
    
    /**
     * 
     * @param string $var
     * @return mixed
     */
    public function __get(string $var);
    
    /**
     * 
     * @param string $var
     * @return bool
     */
    public function __isset(string $var): bool;
    
    /**
     * 
     * @param string $var
     */
    public function __unset(string $var);
}
