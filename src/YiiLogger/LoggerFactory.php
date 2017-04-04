<?php
/**
 * Created by PhpStorm.
 * User: nemutaisama
 * Date: 04.04.17
 * Time: 14:26
 */

namespace Nemutaisama\YiiLogger;


use Monolog\Handler\StreamHandler;

class LoggerFactory
{

    public function createLogger($className, $config) {
        $logger = new \Monolog\Logger('yii');
        foreach($config['handlers'] as $handler) {
            $logger->pushHandler(new StreamHandler(\Yii::getAlias($handler['path']), $handler['level'], $handler['bubble']));
        }
        return $logger;
    }
}