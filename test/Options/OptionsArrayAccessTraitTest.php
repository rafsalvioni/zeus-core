<?php

namespace ZeusTest\Core\Options;

/**
 * 
 * @author Rafael M. Salvioni
 */
class OptionsArrayAccessTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var object
     */
    private $options;
    
    public function setUp()
    {
        $this->options = new TestOptionsArrayAccess();
    }
    
    /**
     * @test
     */
    public function setGetTest() {
        $this->options['int'] = 2;
        $this->assertTrue($this->options['int'] === 2);
        
        $this->options['bool'] = true;
        $this->assertTrue($this->options['bool'] === true);
        
        $this->options['float'] = 8.96;
        $this->assertTrue($this->options['float'] === 8.96);
        
        $this->options['string'] = __FUNCTION__;
        $this->assertTrue($this->options['string'] === __FUNCTION__);
    }
    
    /**
     * @test
     * @depends setGetTest
     */
    public function checkTypeTest() {
        try {
            $this->options['float'] = '';
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
            $this->options['foo'] = '';
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
