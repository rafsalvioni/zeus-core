<?php

namespace ZeusTest\Core\Options;

class TestOptions
{
    use \Zeus\Core\Options\OptionsTrait;

    public function __construct() {
        $this->options = [
            'int'    => 1,
            'bool'   => false,
            'float'  => 2.25,
            'string' => '',
            'flag'   => false,
        ];
    }

    public function __set($name, $value) {
        $this->setOption($name, $value);
    }

    public function __get($name) {
        return $this->getOption($name);
    }

    public function merge(array $options) {
        $this->setOptions($options);
    }

    public function setFlag($bool) {
        $this->checkAndSetOption('flag', $bool);
    }
}
