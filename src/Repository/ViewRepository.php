<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/14
 * Time: 15:57
 */

namespace Pl\HyperfAdmin\Repository;


use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Repository\TemplateEngineRepository;

class ViewRepository
{

    /**
     * 模板名称处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:04
     * @param $str
     * @return mixed
     */
    public static function viewStrInit($str)
    {
        return config('hyperf-admin.view_template_prefix').$str;
    }

    /**
     * 页面返回处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/14
     * Time: 16:01
     * @param RequestInterface $request
     * @param \Pl\HyperfAdmin\Repository\TemplateEngineRepository $render
     * @param $string
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function viewInit(RequestInterface $request,TemplateEngineRepository $render,$string,$data = [])
    {
        $_pjax = $request->input('_pjax','');
        $is_pjax = $_pjax?true:false;
        $data['config']['is_pjax'] = $_pjax;
        $data['config']['prefix'] = config('hyperf-admin.route.prefix');

        /**
         * 判断是否是pjax请求
         * 是的情况返回对应页面
         * 不是的情况返回模板及对应页面
         */
        if($_pjax)
        {
            return $render->render($string,$data);
        }
        else
        {
            $html = $render->render('index',$data);
            // 对应页面数据
            $data['html'] = $html;
            // 页面菜单数据
            $data['menus'] = self::menuInit();
            $data['user'] = AuthRepository::user($view->session);

            return $render->render('layouts.layout',$data);
        }

    }

    /**
     * 页面返回处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/14
     * Time: 16:01
     * @param RequestInterface $request
     * @param \Pl\HyperfAdmin\Repository\TemplateEngineRepository $render
     * @param $string
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public static function viewInitLine(RequestInterface $request,$html,$params = [],SessionInterface $session)
    {
        $data = [];
        $_pjax = $request->input('_pjax','');
        $is_pjax = $_pjax?true:false;
        $data['config']['is_pjax'] = $_pjax;
        $data['config']['prefix'] = config('hyperf-admin.route.prefix');
        $data = array_merge($data,$params);
        /**
         * 判断是否是pjax请求
         * 是的情况返回对应页面
         * $type == 1的情况表示渲染普通数据
         * 不是的情况返回模板及对应页面
         */
        if($_pjax)
        {
            return $html;
        }
        else
        {
            $render = new TemplateEngineRepository();
            $data['html'] = $html;
            // 页面菜单数据
            $data['menus'] = self::menuInit();
            $data['user'] = AuthRepository::user($session);
            $data['out'] =  '/'.config('hyperf-admin.route.prefix').'/'.StateRepository::URL_LOGIN_OUT;

            return $render->render('layouts.layout',$data);
        }

    }

    /**
     * 渲染普通页面
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 17:12
     * @param $str
     * @param array $params
     * @return mixed
     */
    public static function viewInitLineCom($str,$params = [])
    {
        $data = [];
        $data['config']['prefix'] = config('hyperf-admin.route.prefix');
        $data = array_merge($data,$params);
        $render = new TemplateEngineRepository();
        return $render->render($str,$data);
    }

    /**
     * 菜单初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 11:56
     * @return array
     */
    public static function menuInit()
    {
        $data = config('hyperf-admin.menu');
        return $data;
    }
}