<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/14
 * Time: 15:57
 */

namespace Pl\HyperfAdmin\Repository;


use Hyperf\HttpServer\Contract\RequestInterface;
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
        return $str;
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
    public static function viewInitLine(RequestInterface $request,$html,$params = [])
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
        $data = [
            [
                'id' => 7,
                'name' => 'Test首页',
                'path' => '/testindex',
                'icon' => 'fas fa-tachometer-alt',
                'subset' => []
            ],
            [
                'id' => 1,
                'name' => 'Test菜单',
                'path' => '',
                'icon' => 'fas fa-tachometer-alt',
                'subset' => [
                    [
                        'id' => 2,
                        'f_id' => 1,
                        'name' => 'Test首页',
                        'icon' => 'far fa-circle',
                        'path' => '/testindex1',
                    ],
                    [
                        'id' => 3,
                        'f_id' => 1,
                        'name' => 'Test',
                        'icon' => 'far fa-circle',
                        'path' => '/test',
                    ],
                    [
                        'id' => 4,
                        'f_id' => 1,
                        'name' => 'Test1',
                        'icon' => 'far fa-circle',
                        'path' => '/test1',
                    ],
                ],
            ],
            [
                'id' => 5,
                'name' => '系统',
                'path' => '',
                'icon' => 'fas fa-cog',
                'subset' => [
                    [
                        'id' => 6,
                        'f_id' => 5,
                        'name' => '管理员',
                        'icon' => 'fas fa-users',
                        'path' => '/users',
                    ],
                    [
                        'id' => 8,
                        'f_id' => 5,
                        'name' => '管理员添加',
                        'icon' => 'fas fa-users',
                        'path' => '/users/add',
                    ],
                    [
                        'id' => 9,
                        'f_id' => 5,
                        'name' => '管理员修改',
                        'icon' => 'fas fa-users',
                        'path' => '/users/edit',
                    ],
                ],
            ]
        ];
        return $data;
    }
}