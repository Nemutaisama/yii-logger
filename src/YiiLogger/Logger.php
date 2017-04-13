<?php
/**
 * Created by PhpStorm.
 * User: nemutaisama
 * Date: 31.03.17
 * Time: 17:24
 */

namespace Nemutaisama\YiiLogger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Yii;
use yii\log\Logger as FailLogger;

class Logger extends FailLogger
{
    use LoggerTrait;

    /** @var  LoggerInterface */
    private $logger;

    public function __construct(array $config = [])
    {
        $loggerConfig = $config['logger'];
        if (is_array($loggerConfig) && isset($loggerConfig['class'])) {
            $loggerComponent = Yii::createObject($loggerConfig);
        } elseif (is_string($loggerConfig)) {
            $loggerComponent = Yii::createObject($loggerConfig);
        } else {
            throw new \Exception('Cant initialize logger component');
        }
        $this->logger = $loggerComponent->getLogger();
        $this->init();
        Yii::setLogger($this);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function emergency($message, $context = [])
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function alert($message, $context = [])
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function critical($message, $context = [])
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function error($message, $context = [])
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function warning($message, $context = [])
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function notice($message, $context = [])
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function info($message, $context = [])
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array|string  $context
     *
     * @return void
     */
    public function debug($message, $context = [])
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Proxy function to actual logger, handling PSR3 and Yii-way calls
     * @param string|array $levelOrMessage - message in Yii calls, log level in PSR3 calls
     * @param string|int $messageOrLevel - log level in Yii calls, message in PSR3 calls
     * @param array|string $context - category in Yii calls, context in PSR3 calls
     *
     * @return void
     */
    public function log($levelOrMessage, $messageOrLevel, $context = [])
    {
        if (is_array($context) and empty($context)) {
            $context = ['category' => 'application'];
        }
        if (is_string($context)) {
            $context = [
                'category' => $context
            ];
        }

        if (($level = parent::getLevelName($messageOrLevel)) !== 'unknown') {
            $message = $levelOrMessage;
        } else {
            $message = $messageOrLevel;
            $level = $levelOrMessage;
        }

        if (in_array($level, ['trace', 'profile', 'profile begin', 'profile end'])) {
            return;
        }

        $this->getLogger()->log($level, $message, $context);
    }

    public function getLogger()
    {
        return $this->logger;
    }
}