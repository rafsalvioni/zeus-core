<?php

namespace Zeus\Core\Options;

/**
 * Trait to be used by classes that using options configuration.
 *
 * @author Rafael M. Salvioni
 */
trait OptionsTrait
{
    /**
     * Options map
     * 
     * Should be initialized on start
     * 
     * @var array
     */
    protected $options = [];
    
    /**
     * Set a option.
     * 
     * If there is a method named "set$option", it will be called.
     * 
     * @param string $option
     * @param mixed $value
     * @return self
     */
    protected function setOption(string $option, $value)
    {
        $method = "set$option";
        if (\method_exists($this, $method)) {
            $this->$method($value);
        }
        else {
            $this->checkAndSetOption($option, $value);
        }
        return $this;
    }
    
    /**
     * Sets a array of options.
     * 
     * @param array $options
     * @return self
     */
    protected function setOptions(array $options)
    {
        foreach ($options as $option => &$value) {
            $this->setOption($option, $value);
        }
        return $this;
    }

    /**
     * Returns a option value or null if a undefined option.
     * 
     * @param string $option
     * @return mixed
     */
    protected function getOption(string $option)
    {
        $option = \strtolower($option);
        return $this->options[$option] ?? null;
    }
    
    /**
     * Check a option key/value is valid and set it on true.
     * 
     * @param string $option
     * @param mixed $value
     * @return self
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     */
    protected function checkAndSetOption(string $option, $value)
    {
        $option = \strtolower($option);
        if (\array_key_exists($option, $this->options)) {
            $type = \gettype($this->options[$option]);
            if (\gettype($value) == $type) {
                $this->options[$option] = $value;
                return $this;
            }
            throw new \InvalidArgumentException("Value should be a $type type");
        }
        throw new \OutOfBoundsException("Option \"$option\" doesn't exists");
    }
}
