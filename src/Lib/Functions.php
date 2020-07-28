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


    /**
     * 获取随机生成id
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 11:22
     * @return string
     */
    function getID()
    {
        return time().mt_rand(1,100000).mt_rand(1,100000);
    }

    /**
     * 请求外部接口日志 ApplicationContext
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/22
     * Time: 16:34
     * @param $data
     */
    function log_hyperfadmin($data,$name = 'log')
    {
        $log =  \Hyperf\Utils\ApplicationContext::getContainer()->get(\Hyperf\Logger\LoggerFactory::class)->get($name,'hyperfadmin');
        $log->info($data);
    }

    /**
     * 路由前缀拼接
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 10:55
     * @param $url
     * @return string
     */
    public function getUrl($url)
    {
        return '/'.config('hyperf-admin.route.prefix').'/'.$url;
    }

    /**
     * public路径
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 13:22
     * @return string
     */
    public function getPublic()
    {
        return config('hyperf-admin.app_host').'/public/';
    }
}