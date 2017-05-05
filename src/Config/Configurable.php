<?php

namespace Zeus\Core\Config;

use Zeus\Core\Config;

/**
 * Identifies configurable objects.
 * 
 * @author Rafael M. Salvioni
 */
interface Configurable
{
    /**
     * Returns the current config object.
     * 
     * @return Config
     */
    public function getConfig(): Config;
}
