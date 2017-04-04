<?php
/**
 * Created by PhpStorm.
 * User: nemutaisama
 * Date: 31.03.17
 * Time: 17:47
 */

namespace Nemutaisama\YiiLogger;

trait BaseYiiLoggerTrait
{

    private static $logger;

    abstract public function createObject($type, array $params = []);

    /**
     * @return Logger message logger
     */
    public static function getLogger()
    {
        if (self::$logger === null or !(self::$logger instanceof Logger)) {
            self::$logger = static::createObject(Logger::className());
            self::setLogger(self::$logger);
        }

        return self::$logger;
    }

    public static function setLogger($logger)
    {
        self::$logger = $logger;
        parent::setLogger($logger);
    }
    public static function emergency($message, $context = [])
    {
        static::getLogger()->emergency($message, $context);
    }

    public static function alert($message, $context = [])
    {
        static::getLogger()->alert($message, $context);
    }

    public static function critical($message, $context = [])
    {
        static::getLogger()->critical($message, $context);
    }

    public static function error($message, $context = [])
    {
        static::getLogger()->error($message, $context);
    }

    public static function warning($message, $context = [])
    {
        static::getLogger()->warning($message, $context);
    }

    public static function notice($message, $context = [])
    {
        static::getLogger()->notice($message, $context);
    }

    public static function info($message, $context = [])
    {
        static::getLogger()->info($message, $context);
    }

    public static function debug($message, $context = [])
    {
        static::getLogger()->debug($message, $context);
    }

}