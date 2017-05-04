<?php

namespace Zeus\Core;

/**
 * Handles PHP's errors to exceptions when necessary.
 *
 * @author Rafael M. Salvioni
 */
abstract class ErrorHandler
{
    /**
     * Stack of started handlers
     * 
     * @var array
     */
    private static $stack = [];
    
    /**
     * Checks if the ErrorHandler is started.
     * 
     * @return bool
     */
    public static function isStarted()
    {
        return !empty(static::$stack);
    }
    
    /**
     * Starting the ErrorHandler.
     * 
     * @param int $level
     */
    public static function start($level = \E_ALL)
    {
        static::$stack[] = null;
        \set_error_handler([__CLASS__, 'handle'], $level);
    }
    
    /**
     * Stop the current ErrorHandler.
     * 
     * @param bool $throw Throws a eventual exception?
     * @return \ErrorException
     */
    public static function stop($throw = true)
    {
        if (static::isStarted()) {
            $exception = \array_pop(static::$stack);
            \restore_error_handler();

            if (($exception instanceof \ErrorException) && $throw) {
                throw $exception;
            }
            return $exception;
        }
        return null;
    }
    
    /**
     * Stop all handlers.
     * 
     */
    public static function clean()
    {
        while (!empty(static::$stack)) {
            static::stop(false);
        }
    }
    
    /**
     * Error handler callback.
     * 
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     */
    public static function handle($errno, $errstr, $errfile, $errline)
    {
        $stack =& static::$stack[\count(static::$stack) - 1];
        $stack = new \ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}
