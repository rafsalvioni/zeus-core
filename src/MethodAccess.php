<?php

namespace Zeus\Core;

/**
 * Interface to provides methods call access using magic methods.
 * 
 * @author Rafael M. Salvioni
 */
interface MethodAccess
{
    /**
     * 
     * @param string $method
     * @param array $args
     */
    public function __call(string $var, array $args);
}
