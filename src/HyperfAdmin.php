<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 16:10
 */

namespace Pl\HyperfAdmin;

use Pl\HyperfAdmin\Repository\TemplateEngineRepository;

class HyperfAdmin
{
    /**
     * 模板编译方法
     * @var TemplateEngineRepository
     */
    protected $render;

    /**
     * 标题
     * @var
     */
    public $title;


    /**
     * 面包屑
     * @var array
     */
    public $breadcrumb = [];
    /**
     * 路由
     * @var
     */
    public $route;
    /**
     * 是否在首页
     * @var
     */
    public $isIndex = false;


    /**
     * 副标题
     * @var
     */
    public $subTitle;

    public function __construct()
    {
        $this->render = new TemplateEngineRepository();
    }

    /**
     * 面包屑初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 16:53
     */
    protected function breadcrumbInit()
    {
        $data = [
            [
                'path' => '/index',
                'active' => '',
                'name' => '首页'
            ],
            [
                'path' => $this->route,
                'active' => $this->isIndex?'active':'',
                'name' => $this->title
            ]
        ];
        $this->breadcrumb = array_merge($data,$this->breadcrumb);
    }
}