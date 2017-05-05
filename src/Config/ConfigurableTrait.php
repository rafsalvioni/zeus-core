<?php

namespace Zeus\Core\Config;

use Zeus\Core\Config;

/**
 * Trait to implement default methods of Configurable interface.
 *
 * @author Rafael M. Salvioni
 */
trait ConfigurableTrait
{
    /**
     * Current coniguration
     * 
     * @var Config
     */
    protected $config;
    
    /**
     * 
     * @return Config
     */
    public function getConfig(): Config
    {
        if (!$this->config) {
            $this->config = new Config();
        }
        return $this->config;
    }
}
