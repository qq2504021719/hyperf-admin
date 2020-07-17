<?php
namespace Pl\HyperfAdmin\Lib;
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 11:58
 */

trait Functions
{
    /**
     * 判断数组指定下标是否存在,存在则返回数据
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/27
     * Time: 16:24
     * @param $arr
     * @param $key
     * @param $default
     * @return string
     */
    function arrIsKey($arr,$key,$default = null)
    {
        $re = $default;
        if(is_array($arr))
        {
            $re = isset($arr[$key])?$arr[$key]:$re;
        }
        else if(is_object($arr))
        {
            try{
                $re = $arr->$key;
            }catch (\Exception $e)
            {
            }
        }
        return $re;
    }
}