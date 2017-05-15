<?php

namespace ZeusTest\Core;

class TestArrayAccess implements \ArrayAccess, \Zeus\Core\Overloadable
{
    use \Zeus\Core\ArrayAccessOverloadTrait;
    
    public function offsetExists($offset) {
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
}
