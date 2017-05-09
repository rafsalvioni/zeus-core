<?php

namespace ZeusTest\Core;

/**
 * 
 * @author Rafael M. Salvioni
 */
class OverloadableTest extends \PHPUnit_Framework_TestCase
{
    private $object;
    
    public function setUp()
    {
        $this->object = new class implements \Zeus\Core\Overloadable, \ArrayAccess {
            use \Zeus\Core\ArrayAccessOverloadTrait;
            
            public function offsetExists($offset): bool {
                return true;
            }

            public function offsetGet($offset) {
                return __FUNCTION__;
            }

            public function offsetSet($offset, $value) {
                echo __FUNCTION__;
            }

            public function offsetUnset($offset) {
                echo __FUNCTION__;
            }
        };
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
