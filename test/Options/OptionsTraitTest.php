<?php

namespace ZeusTest\Core\Options;

/**
 * 
 * @author Rafael M. Salvioni
 */
class OptionsTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var object
     */
    private $options;
    
    public function setUp()
    {
        $this->options = new TestOptions();
    }
    
    /**
     * @test
     */
    public function setGetTest() {
        $this->options->int = 2;
        $this->assertTrue($this->options->int === 2);
        
        $this->options->bool = true;
        $this->assertTrue($this->options->bool === true);
        
        $this->options->float = 8.96;
        $this->assertTrue($this->options->float === 8.96);
        
        $this->options->string = __FUNCTION__;
        $this->assertTrue($this->options->string === __FUNCTION__);
    }
    
    /**
     * @test
     */
    public function setOptionsTest() {
        $this->options->merge([
            'int' => 25,
            'float' => 5.6,
            'bool' => false
        ]);
        
        $this->assertTrue(
            $this->options->float === 5.6 &&
            $this->options->int === 25 &&
            $this->options->bool === false
        );
    }
    
    /**
     * @test
     * @depends setGetTest
     */
    public function setterTest() {
        $this->options->setFlag(true);
        $this->assertTrue($this->options->flag === true);
    }
    
    /**
     * @test
     * @depends setGetTest
     */
    public function checkTypeTest() {
        try {
            $this->options->float = '';
            $this->assertTrue(false);
        }
        catch (\InvalidArgumentException $ex) {
            $this->assertTrue(true);
        }
        catch (\Throwable $ex) {
            $this->assertTrue(false);
        }
        
        try {
            $this->options->merge([
                'int' => 5.6
            ]);
            $this->assertTrue(false);
        }
        catch (\InvalidArgumentException $ex) {
            $this->assertTrue(true);
        }
        catch (\Throwable $ex) {
            $this->assertTrue(false);
        }
    }
    
    /**
     * @test
     * @depends setGetTest
     */
    public function checkOptionTest() {
        try {
            $this->options->foo = '';
            $this->assertTrue(false);
        }
        catch (\OutOfBoundsException $ex) {
            $this->assertTrue(true);
        }
        catch (\Throwable $ex) {
            $this->assertTrue(false);
        }
        
        try {
            $this->options->merge([
                'foo' => 5.6
            ]);
            $this->assertTrue(false);
        }
        catch (\OutOfBoundsException $ex) {
            $this->assertTrue(true);
        }
        catch (\Throwable $ex) {
            $this->assertTrue(false);
        }
    }
}
