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
     * Add one or more flags on a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function addFlag(int $mask, int ...$flag): int
    {
        foreach ($flag as &$f) {
            $mask = ($mask | $f);
        }
        return $mask;
    }
    
    /**
     * Remove one or more flags from a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function removeFlag(int $mask, int ...$flag): int
    {
        foreach ($flag as &$f) {
            $mask = ($mask & ~$f);
        }
        return $mask;
    }
    
    /**
     * Checks if a flag is set on a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return bool
     */
    public static function hasFlag(int $mask, int $flag): bool
    {
        return ($mask & $flag) != 0;
    }
    
    /**
     * Toogle a flag on a mask.
     * 
     * @param int $mask
     * @param int $flag
     * @return int
     */
    public static function toogleFlag(int $mask, int $flag): int
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
    public static function isSingleFlag(int $flag): bool
    {
        return $flag != 0 && ($flag & ($flag - 1)) === 0;
    }
    
    /**
     * Returns a list that contains all single flags defined on a mask.
     * 
     * @param int $mask
     * @return int[]
     */
    public static function maskToFlags(int $mask): array
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
     * Adds one or more flags on this mask.
     * 
     * @param int $flag
     * @return self
     */
    public function add(int ...$flag): self
    {
        $this->mask = self::addFlag($this->mask, ...$flag);
        return $this;
    }

    /**
     * Removes one or more flags from this mask.
     * 
     * @param int $flag
     * @return self
     */
    public function remove(int ...$flag): self
    {
        $this->mask = self::removeFlag($this->mask, ...$flag);
        return $this;
    }
    
    /**
     * Returns a new mask using current mask with $flags active.
     * 
     * @param int $flag
     * @return BitMask
     */
    public function with(int $flag): BitMask
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
    public function without(int $flag): BitMask
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
    public function has(int $flag): bool
    {
        return self::hasFlag($this->mask, $flag);
    }
    
    /**
     * Toogles a flag and return the new mask.
     * 
     * @param int $flag
     * @return self
     */
    public function toogle(int $flag): self
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
    public function bind(int &$mask): self
    {
        $this->mask =& $mask;
        return $this;
    }

    /**
     * Returns the mask.
     * 
     * @return int
     */
    public function getMask(): int
    {
        return $this->mask;
    }
}
