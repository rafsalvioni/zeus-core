<?php

namespace ZeusTest\Core;

use Zeus\Core\ErrorHandler;

/**
 *
 * @author Rafael M. Salvioni
 */
class ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function startStopTest()
    {
        try {
            ErrorHandler::start();
            \trigger_error("UserError", \E_USER_ERROR);
            ErrorHandler::stop();
            $this->assertTrue(false);
        }
        catch (\Exception $ex) {
            $this->assertEquals("UserError", $ex->getMessage());
        }
        
        try {
            ErrorHandler::start(\E_USER_WARNING);
            \trigger_error("UserError", \E_USER_NOTICE);
            ErrorHandler::stop();
            $this->assertTrue(true);
        }
        catch (\Exception $ex) {
            $this->assertTrue(false);
        }
    }
    
    /**
     * @test
     * @depends startStopTest
     */
    public function tryThisTest()
    {
        $f = function() {
            trigger_error("UserError", \E_USER_WARNING);
            return 666;
        };
        try {
            ErrorHandler::tryThis($f);
            $this->assertTrue(false);
        }
        catch (\Exception $ex) {
            $this->assertEquals("UserError", $ex->getMessage());
        }
        try {
            ErrorHandler::tryThis($f, \E_USER_NOTICE);
            $this->assertTrue(true);
        }
        catch (\Exception $ex) {
            $this->assertTrue(false);
        }
    }
    
    /**
     * @test
     * @depends startStopTest
     */
    public function startedTest()
    {
        ErrorHandler::start();
        $this->assertTrue(ErrorHandler::isStarted());
        ErrorHandler::stop();
        $this->assertFalse(ErrorHandler::isStarted());
    }
    
    /**
     * @test
     * @depends startedTest
     */
    public function cleanTest()
    {
        $n = \mt_rand(1, 20);
        for ($i = 0; $i < $n; $i++) {
            ErrorHandler::start();
        }
        ErrorHandler::clean();
        $this->assertFalse(ErrorHandler::isStarted());
        
        try {
            \trigger_error("UserError", \E_USER_NOTICE);
            ErrorHandler::stop();
            $this->assertTrue(false);
        }
        catch (\PHPUnit_Framework_Error_Notice $ex) {
            $this->assertTrue(true);
        }
    }
}
