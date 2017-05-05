<?php

namespace Zeus\Core;

/**
 * Helper class to encapsulate configurations
 *
 * @author Rafael M. Salvioni
 */
class Config implements
    \Countable,
    \IteratorAggregate,
    \ArrayAccess,
    ObjectAccess
{
    use ObjectToArrayTrait;
    
    private $config   = [];
    private $readOnly = [];
    
    public function __construct(array $defaultConfig = [], array $readOnly = [])
    {
        $this->config   = $defaultConfig;
        $this->readOnly = \array_values($readOnly);
        
        $this->config   = \array_change_key_case($this->config);
        $this->readOnly = \array_map('\\strtolower', $this->readOnly);
    }
    
    public function set(string $key, $value): Config
    {
        $key = \strtolower($key);
        $this->checkAndSet($key, $value);
        return $this;
    }
    
    public function setAll(array $config): Config
    {
        foreach ($config as $key => &$val) {
            $this->set($key, $val);
        }
        return $this;
    }
    
    public function get(string $key, $defaultValue = null)
    {
        $key = \strtolower($key);
        return $this->config[$key] ?? $defaultValue;
    }
    
    public function has(string $key): bool
    {
        $key = \strtolower($key);
        return \array_key_exists($key, $this->config);
    }
    
    public function merge(Config $config)
    {
        $default  = \array_merge($this->config, $config->config);
        $readOnly = \array_merge($this->readOnly, $config->readOnly);
        return new self($default, $readOnly);
    }
    
    public function toArray(): array
    {
        return $this->config;
    }
    
    public function count(): int
    {
        return \count($this->config);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->config);
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
    }
    
    private function checkAndSet(string $key, $value)
    {
        if (\array_key_exists($key, $this->config)) {
            $type = \gettype($this->config[$key]);
            $ro   = \in_array($key, $this->readOnly);
            
            if ($ro) {
                throw new \RuntimeException("Config \"$key\" is read only");
            }
            else if ($type != \gettype($value)) {
                throw new \RuntimeException("Config \"$key\" should be a $type value");
            }
            else {
                $this->config[$key] = $value;
            }
        }
        throw new \RuntimeException("Config \"$key\" is undefined");
    }
}
