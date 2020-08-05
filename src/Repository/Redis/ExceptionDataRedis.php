<?php
namespace Pl\HyperfAdmin\Repository\Redis;
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/5
 * Time: 10:12
 */

class ExceptionDataRedis
{
    public function set(\Exception $exception)
    {
        var_dump([
            $exception->getMessage(), // 错误提示
            $exception->getTraceAsString() // 详细内容
        ]);
    }

    public function get()
    {

    }
}