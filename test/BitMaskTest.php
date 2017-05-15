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
        $this->assertEquals($this->bitmask->add($flags)->getMask(), self::MASK + $flags);
    }
    
    /**
     * @test
     * @depends addTest
     */
    public function addTest2()
    {
        $flags = 258;
        $this->assertEquals($this->bitmask->add($flags)->getMask(), self::MASK + $flags);
    }
    
    /**
     * @test
     * @depends addTest2
     */
    public function addVaryFlags()
    {
        $flags = [2,15,32,127,512];
        $bit   = clone $this->bitmask;
        $bit->add(...$flags);
        $mask  = BitMask::addFlag(self::MASK, ...$flags);
        
        while ($flags) {
            $this->bitmask->add(\array_shift($flags));
        }
        $this->assertTrue($bit->getMask() === $this->bitmask->getMask() && $bit->getMask() === $mask);
    }
    
    /**
     * @test
     */
    public function addRemoveVarParamTest()
    {
        $mask = new BitMask;
        $flags = [2, 4, 8];
        $this->assertEquals($mask->add(...$flags)->getMask(), 14);
        $this->assertEquals($mask->remove(...$flags)->getMask(), 0);
        $this->assertEquals(BitMask::addFlag(0, ...$flags), 14);
        $this->assertEquals(BitMask::removeFlag(14, ...$flags), 0);
    }
    
    /**
     * @test
     */
    public function withOutTest()
    {
        $ret1 = $this->bitmask->with(256, 512);
        $ret2 = $this->bitmask->without(256, 512);
        $this->assertTrue(
            $ret1 instanceof BitMask
            && $ret2 instanceof BitMask
            && $ret1 !== $this->bitmask
            && $ret2 !== $this->bitmask
            && $ret2 !== $ret1
            && $ret1->getMask() === self::MASK + 768
            && $ret2->getMask() === self::MASK
        );
    }
    
    /**
     * @test
     */
    public function removeTest()
    {
        $flags = 5;
        $this->assertEquals($this->bitmask->remove($flags)->getMask(), self::MASK - $flags);
    }
    
    /**
     * @test
     * @depends removeTest
     */
    public function removeTest2()
    {
        $this->assertEquals($this->bitmask->remove(256)->getMask(), self::MASK);
    }
    
    /**
     * @test
     * @depends removeTest2
     */
    public function removeVaryFlags()
    {
        $flags = [2,15,32,127,512];
        $bit   = clone $this->bitmask;
        $bit->remove(...$flags);
        $mask  = BitMask::removeFlag(self::MASK, ...$flags);
        
        while ($flags) {
            $this->bitmask->remove(\array_shift($flags));
        }
        $this->assertTrue($bit->getMask() === $this->bitmask->getMask() && $bit->getMask() === $mask);
    }
    
    /**
     * @test
     */
    public function muttableTest()
    {
        $this->assertTrue(
            $this->bitmask->add(1024) === $this->bitmask
            && $this->bitmask->getMask() == self::MASK + 1024
            && $this->bitmask->remove(1024) === $this->bitmask
            && $this->bitmask->getMask() == self::MASK
        );
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
        $this->assertFalse(
            $this->bitmask->without(72)->has(64)
            || $this->bitmask->has(256)
            || $this->bitmask->has(0)
        );
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
    public function toogleTest2()
    {
        $this->assertTrue($this->bitmask->toogle(73) === $this->bitmask);
    }
    
    /**
     * @test
     */
    public function bindTest()
    {
        $binded = 128;
        $this->bitmask->bind($binded);
        $this->assertTrue(
            $this->bitmask->add(64) === $this->bitmask
            && $binded === 192
        );
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
            && !BitMask::isSingleFlag(0)
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
        }
        $mask   = BitMask::addFlag($mask, ...$flags);
        $flags  = \array_unique($flags);
        \sort($flags);
        
        $flags2 = BitMask::maskToFlags($mask);
        
        $this->assertTrue($flags === $flags2);
    }
}
