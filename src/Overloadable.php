<?php

namespace Zeus\Core;

/**
 * Interface to force classes to define overloading PHP's magic methods.
 * 
 * @see http://php.net/manual/en/language.oop5.overloading.php
 * @author Rafael M. Salvioni
 */
interface Overloadable
{
    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, $value);
    
    /**
     * 
     * @param string $name
     */
    public function __get(string $name);
    
    /**
     * 
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool;
    
    /**
     * 
     * @param string $name
     */
    public function __unset(string $name);
}
