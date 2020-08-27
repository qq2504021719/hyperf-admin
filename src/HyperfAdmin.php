<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 16:10
 */

namespace Pl\HyperfAdmin;

use App\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\TemplateEngineRepository;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Pl\HyperfAdmin\Repository\ViewRepository;

class HyperfAdmin
{
    use Functions;
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
     * session
     * @var SessionInterface
     */
    public $session;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    public $validationFactory;

    /**
     * 标题
     * @var
     */
    public $title;

    /**
     * 页面内容
     * @var
     */
    protected $html = '';
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
     * 模型-query
     * @var
     */
    public $model;

    /**
     * 模型
     * @var
     */
    protected $modelM;

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

    public function __construct(Model $model)
    {
        $this->render = new TemplateEngineRepository();
        $this->modelM = $model;
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
                'path' => config('hyperf-admin.login_url'),
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

    /**
     * 头部信息
     * 标题 副标题
     * 快捷导航
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:33
     */
    protected function contentHeader()
    {
        // 面包屑初始化
        $this->breadcrumbInit();

        $html = ViewRepository::viewInitLineCom('content.header',[
            'title' => $this->title,
            'subTitle' => $this->subTitle,
            'breadcrumb' => $this->breadcrumb,
        ]);
        $this->html .= $html;
    }

    /**
     * 菜单选中变量
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 19:12
     * @return string
     */
    protected function getFPathScript()
    {
        return "var f_path = '/".config('hyperf-admin.route.prefix').$this->route."'";
    }

    /**
     * 页面提示
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/25
     * Time: 14:42
     */
    public function getToastr()
    {
        $re = '';
        $key = StateRepository::TOASTR_NAME;
        $data = $this->session->get($key);
        $this->session->set($key,[]);
        $str = $this->arrIsKey($data,'str');
        $type = $this->arrIsKey($data,'type');
        $title = $this->arrIsKey($data,'title');
        if($str && $type)
        {
            if($title) $title = ',"'.$title.'"';
            $re = '<script>toastr.'.$type.'("'.$str.'"'.$title.')</script>';
        }
        return $re;
    }

    /**
     * 模版script
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/25
     * Time: 15:13
     * @param $data
     */
    public function layoutScript($data)
    {
        //不存在创建
        if(!isset($data['script'])) $data['script'] = '';
        // 页面提示
        $data['script'] .= $this->getToastr();
        return $data;
    }

}