<?php
/**
 * Created by PhpStorm.
 * User: nemutaisama
 * Date: 31.03.17
 * Time: 18:52
 */

namespace Nemutaisama\YiiLogger;


class YiiCompatibleLogger
{

    public function info($message, array $context = [])
    {
        var_dump($context);
    }

    public function log($message, $level, $category = 'application')
    {

    }

    public function flush($final = false)
    {
        return true;
    }
}