<?php

namespace Zeus\Core\Options;

/**
 * Trait that implements \ArrayAccess methods to be used with OptionsTrait.
 *
 * @author Rafael M. Salvioni
 */
trait OptionsArrayAccessTrait
{
    use OptionsTrait;
    
    /**
     * 
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return \array_key_exists($this->options, (string)$offset);
    }

    /**
     * 
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getOption($offset);
    }

    /**
     * 
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->setOption($offset, $value);
    }

    /**
     * Do nothing
     * 
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        //noop
    }
}
