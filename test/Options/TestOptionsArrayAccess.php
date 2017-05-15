<?php

namespace ZeusTest\Core\Options;

class TestOptionsArrayAccess implements \ArrayAccess
{
    use \Zeus\Core\Options\OptionsArrayAccessTrait;

    public function __construct() {
        $this->options = [
            'int'    => 1,
            'bool'   => false,
            'float'  => 2.25,
            'string' => '',
            'flag'   => false,
        ];
    }
}
