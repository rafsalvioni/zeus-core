<?php

namespace Zeus\Core;

/**
 * Handles PHP's errors to exceptions when necessary.
 *
 * @author Rafael M. Salvioni
 */
class ErrorHandler
{
    /**
     * Count opened instances
     * 
     * @var int
     */
    private static $opened        = 0;
    /**
     * Consider use of error operator (@)?
     * 
     * @var bool
     */
    private static $suppressErrors = false;
    /**
     * Consider current error reporting level?
     * 
     * @var bool
     */
    private static $errorReporting = false;

    /**
     * Start the error's handler engine.
     * 
     * @param bool $useSuppress Consider use of error operator?
     * @param bool $useErrorLevel Consider current error reporting level?
     * @param bool $errorTypes Custom error types to consider
     */
    public static function start(
        $useSuppress = false, $useErrorLevel = false, $errorTypes = \E_ALL
    ) {
        if (self::$opened++ == 0) {
            \set_error_handler([__CLASS__, 'handle'], $errorTypes);
            self::$suppressErrors = (bool)$useSuppress;
            self::$errorReporting = (bool)$useErrorLevel;
        }
    }
    
    /**
     * Stop handler engine.
     * 
     */
    public static function stop()
    {
        if (self::$opened > 0 && --self::$opened == 0) {
            \restore_error_handler();
        }
    }
    
    /**
     * Error's handler.
     * 
     * If a exceptions was fired, the engine will be stopped automatically.
     * 
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @throws \ErrorException
     */
    public static function handle($errno, $errstr, $errfile, $errline)
    {
        if (self::$opened > 0) {
            $errorReporting = \error_reporting();
            if ($errorReporting == 0) {
                $throws = !self::$suppressErrors;
            }
            else {
                $throws = !self::$errorReporting || ($errorReporting & $errno) > 0;
            }
            if ($throws) {
                self::stop();
                throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
        }
    }
}
