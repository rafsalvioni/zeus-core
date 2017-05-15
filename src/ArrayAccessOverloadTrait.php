<?php

namespace Zeus\Core;

/**
 * Trait to be used in objects that implements \ArrayAccess interface.
 * 
 * Its provides access to \ArrayAccess methods using __set, __get, __isset
 * and __unset magic methods.
 *
 * @see http://php.net/manual/en/language.oop5.overloading.php
 * @author Rafael M. Salvioni
 */
trait ArrayAccessOverloadTrait
{
    /**
     * 
     * @param string $var
     * @return mixed
     */
    public function __get($var)
    {
        return $this->offsetGet($var);
    }

    /**
     * 
     * @param string $var
     * @return bool
     */
    public function __isset($var)
    {
        return $this->offsetExists($var)
                && $this->offsetGet($var) != null;
    }

    /**
     * 
     * @param string $var
     * @param mixed $value
     */
    public function __set($var, $value)
    {
        $this->offsetSet($var, $value);
    }

    /**
     * 
     * @param string $var
     */
    public function __unset($var)
    {
        $this->offsetUnset($var);
    }
}
