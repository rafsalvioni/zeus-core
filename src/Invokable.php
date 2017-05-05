<?php

namespace Zeus\Core;

/**
 * Interface to allow objects to be called as a function.
 * 
 * @author Rafael M. Salvioni
 */
interface Invokable
{
    /**
     * 
     */
    public function __invoke();
}
