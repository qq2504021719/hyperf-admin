<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 16:10
 */

namespace Pl\HyperfAdmin;

use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\TemplateEngineRepository;

class HyperfAdmin
{

    /**
     * 请求
     * @var RequestInterface
     */
    public $request;

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
     * 模型
     * @var
     */
    public $model;


    /**
     * 副标题
     * @var
     */
    public $subTitle;

    /**
     * 主题色
     * @var string
     */
    public $themeColor = StateRepository::BOOTSTRAP_COLOR_PRIMARY;

    public function __construct(HyperfAdminModel $model)
    {
        $this->render = new TemplateEngineRepository();
        $this->model = $model->newModelQuery();

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