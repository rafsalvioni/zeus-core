<?php

namespace Zeus\Core;

/**
 * Trait to be used in objects that implements \ArrayAccess interface.
 * 
 * Its provides access to \ArrayAccess methods implementing magic methods.
 *
 * @author Rafael M. Salvioni
 */
trait ObjectToArrayTrait
{
    /**
     * 
     * @param string $var
     * @return mixed
     */
    public function __get(string $var)
    {
        return $this->offsetGet($var);
    }

    /**
     * 
     * @param string $var
     * @return bool
     */
    public function __isset(string $var): bool
    {
        return $this->offsetExists($var);
    }

    /**
     * 
     * @param string $var
     * @param mixed $value
     */
    public function __set(string $var, $value)
    {
        $this->offsetSet($var, $value);
    }

    /**
     * 
     * @param string $var
     */
    public function __unset(string $var)
    {
        $this->offsetUnset($var);
    }
}
