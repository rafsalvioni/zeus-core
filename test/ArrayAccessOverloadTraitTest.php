<?php

namespace ZeusTest\Core;

/**
 * 
 * @author Rafael M. Salvioni
 */
class ArrayAccessOverloadTraitTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    
    public function setUp()
    {
        $this->object = new TestArrayAccess();
    }
    
    /**
     * @test
     */
    public function mainTest() {
        //offsetExists
        $this->assertTrue(isset($this->object->foo));
        //offsetGet
        $this->assertTrue($this->object->foo === 'offsetGet');
        //offsetSet
        $this->object->foo = false;
        $this->expectOutputRegex('/offsetSet/i');
        //offsetSet
        unset($this->object->foo);
        $this->expectOutputRegex('/offsetUnset/i');
    }
}
