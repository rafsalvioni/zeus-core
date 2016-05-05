<?php

namespace Zeus\Core;

/**
 * Helper class to manipulate bitmasks.
 *
 * @author Rafael M. Salvioni
 */
class BitMask
{
    /**
     * Bitmask
     * 
     * @var int
     */
    private $mask;
    
    /**
     * Add a flag to a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function addFlag($mask, $flag)
    {
        return ($mask | $flag);
    }
    
    /**
     * Remove a flag from a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function removeFlag($mask, $flag)
    {
        return ($mask & ~$flag);
    }
    
    /**
     * Checks if a flag is set on a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return bool
     */
    public static function hasFlag($mask, $flag)
    {
        return ($mask & $flag) === \min($mask, $flag);
    }
    
    /**
     * Toogle a flag on a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function toogleFlag($mask, $flag)
    {
        return self::hasFlag($mask, $flag) ?
               self::removeFlag($mask, $flag) :
               self::addFlag($mask, $flag);
    }

    /**
     * Checks if a value is a single flag.
     * 
     * A single flag should be a number that is a power of 2.
     * 
     * @param int $flag
     * @return bool
     */
    public static function isSingleFlag($flag)
    {
        return ($flag & ($flag - 1)) === 0;
    }
    
    /**
     * Returns a list that contains all single flags defined on a mask.
     * 
     * @param int $mask
     * @return int[]
     */
    public static function maskToFlags($mask)
    {
        $flags = [];
        $flag  = 1;
        
        while ($mask > 0) {
            if (self::hasFlag($mask, $flag)) {
                $flags[] = $flag;
                $mask    = self::removeFlag($mask, $flag);
            }
            $flag = $flag << 1;
        }
        return $flags;
    }

    /**
     * 
     * @param int $mask
     */
    public function __construct($mask = 0)
    {
        $this->mask = (int)$mask;
    }
    
    /**
     * Adds a flag on this mask.
     * 
     * @param int $flag
     * @return self
     */
    public function add($flag)
    {
        $this->mask = self::addFlag($this->mask, $flag);
        return $this;
    }

    /**
     * Removes a flag from this mask.
     * 
     * @param int $flag
     * @return self
     */
    public function remove($flag)
    {
        $this->mask = self::removeFlag($this->mask, $flag);
        return $this;
    }
    
    /**
     * Returns a new mask using current mask with $flags active.
     * 
     * @param int $flag
     * @return BitMask
     */
    public function with($flag)
    {
        $mask = self::addFlag($this->mask, $flag);
        return new self($mask);
    }
    
    /**
     * Returns a new mask using current mask without $flags.
     * 
     * @param int $flag
     * @return BitMask
     */
    public function without($flag)
    {
        $mask = self::removeFlag($this->mask, $flag);
        return new self($mask);
    }
    
    /**
     * Checks if this mask has a flag.
     * 
     * @param int $flag
     * @return bool
     */
    public function has($flag)
    {
        return self::hasFlag($this->mask, $flag);
    }
    
    /**
     * Toogles a flag and return the new mask.
     * 
     * @param int $flag
     * @return self
     */
    public function toogle($flag)
    {
        $this->mask = self::toogleFlag($this->mask, $flag);
        return $this;
    }
    
    /**
     * Binds a value to this mask.
     * 
     * @param int $mask
     * @return self
     */
    public function bind(&$mask)
    {
        $this->mask =& $mask;
        $this->mask = (int)$this->mask;
        return $this;
    }

    /**
     * Returns the mask.
     * 
     * @return int
     */
    public function getMask()
    {
        return $this->mask;
    }
}
