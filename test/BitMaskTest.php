<?php

namespace ZeusTest\Core;

use Zeus\Core\BitMask;

/**
 * 
 * @author Rafael M. Salvioni
 */
class BitMaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Default mask
     */
    const MASK = 205;
    /**
     *
     * @var BitMask
     */
    private $bitmask;
    
    public function setUp()
    {
        $this->bitmask = new BitMask(self::MASK);
    }

    /**
     * @test
     */
    public function addTest()
    {
        $flags = 18;
        $this->assertEquals($this->bitmask->with($flags)->getMask(), self::MASK + $flags);
    }
    
    /**
     * @test
     */
    public function addTest2()
    {
        $flags = 258;
        $this->assertEquals($this->bitmask->with($flags)->getMask(), self::MASK + $flags);
    }
    
    /**
     * @test
     */
    public function removeTest()
    {
        $flags = 5;
        $this->assertEquals($this->bitmask->without($flags)->getMask(), self::MASK - $flags);
    }
    
    /**
     * @test
     */
    public function removeTest2()
    {
        $this->assertEquals($this->bitmask->without(256)->getMask(), self::MASK);
    }
    
    /**
     * @test
     */
    public function hasTest()
    {
        $this->assertTrue($this->bitmask->has(132));
    }
    
    /**
     * @test
     */
    public function hasNotTest()
    {
        $this->assertFalse($this->bitmask->without(72)->has(64));
    }
    
    /**
     * @test
     */
    public function hasNotTest2()
    {
        $this->assertFalse($this->bitmask->has(256));
    }
    
    /**
     * @test
     */
    public function toogleTest()
    {
        $this->assertEquals($this->bitmask->toogle(73)->toogle(73)->getMask(), self::MASK);
    }
    
    /**
     * @test
     */
    public function compositeTest()
    {
        $flag = 1;
        $rand = \mt_rand(0, 5);
        $flag = $flag << $rand;
        $this->assertTrue(
            !BitMask::isSingleFlag($flag > 2 ? $flag + 2 : 3)
            && BitMask::isSingleFlag($flag)
        );
    }
    
    /**
     * @test
     * @depends addTest
     * @depends addTest2
     */
    public function flagsTest()
    {
        $flags = [];
        $mask  = 0;
        
        while (\count($flags) < 5) {
            $power   = \mt_rand(0, 10);
            $flag    = \pow(2, $power);
            $flags[] = $flag;
            $mask    = BitMask::addFlag($mask, $flag);
        }
        $flags  = \array_unique($flags);
        \sort($flags);
        
        $flags2 = BitMask::getFlags($mask);
        
        $this->assertTrue($flags === $flags2);
    }
}
