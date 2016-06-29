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
    public function startTest()
    {
        try {
            ErrorHandler::start();
            \trigger_error("UserError", \E_USER_ERROR);
            $this->assertTrue(false);
        }
        catch (\ErrorException $ex) {
            $this->assertEquals($ex->getMessage(), "UserError");
        }
        ErrorHandler::stop();
        
        try {
            ErrorHandler::start(true);
            @\trigger_error("UserError", \E_USER_ERROR);
            $this->assertTrue(true);
        }
        catch (\ErrorException $ex) {
            $this->assertTrue(false);
        }
        ErrorHandler::stop();
        
        try {
            ErrorHandler::start(false, true);
            \error_reporting(E_USER_WARNING);
            \trigger_error("UserError", \E_USER_ERROR);
            $this->assertTrue(true);
        }
        catch (\ErrorException $ex) {
            $this->assertTrue(false);
        }
        ErrorHandler::stop();
        
        try {
            ErrorHandler::start(false, false, \E_USER_WARNING);
            \trigger_error("UserError", \E_USER_WARNING);
            $this->assertTrue(false);
        }
        catch (\ErrorException $ex) {
            $this->assertTrue(true);
        }
        ErrorHandler::stop();
    }
    
    /**
     * @test
     * @depends startTest
     */
    public function stopTest()
    {
        $called = false;
        \set_error_handler(function ($errno, $errmsg) use (&$called) {
            $called = true;
        });

        ErrorHandler::start();
        ErrorHandler::stop();
        
        @\trigger_error('Notice', \E_USER_NOTICE);
        $this->assertTrue($called); 
   }
   
   /**
    * @test
    * @depends stopTest
    */
   public function multipleStartTest()
   {
        $called = false;
        \set_error_handler(function ($errno, $errmsg) use (&$called) {
            $called = true;
        });
        
        $n = \mt_rand(5, 15);
        for ($i = 0; $i < $n; $i++) {
            ErrorHandler::start();
        }
        
        ErrorHandler::stop();
        try {
            @\trigger_error('Notice', \E_USER_NOTICE);
            $this->assertFalse(true);
        }
        catch (\ErrorException $ex) {
            $this->assertFalse($called);
        }
        
        $n -= 2;
        for ($i = 0; $i < $n; $i++) {
            ErrorHandler::stop();
        }
        @\trigger_error('Notice', \E_USER_NOTICE);
        $this->assertTrue($called);
   }
}
