<?php
/**
 * 后台用户管理
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 14:09
 */

namespace Pl\HyperfAdmin\Controllers;


use App\Controller\AbstractController;
use Pl\HyperfAdmin\Grid\Grid;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Repository\ViewRepository;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers
 * @Controller(prefix="/admin/users")
 */
class UsersController extends HyperfAdminController
{
    /**
     * 标题
     * @var string
     */
    protected $title = '管理员';

    /**
     * 副标题
     * @var string
     */
    protected $subTitle = '';

    /**
     * 面包屑
     * @var array
     */
    public $breadcrumb = [];

    /**
     * 初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 16:09
     * @param $object
     */
    public function initData(HyperfAdmin $object)
    {
        $object->title = $this->title;
        $object->subTitle = $this->subTitle;
        $object->breadcrumb = $this->breadcrumb;
        $object->route = '/users';
    }

    /**
     * 列表页
     * @RequestMapping(path="")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:36
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $grid = new Grid();
        $grid->isIndex = true;
        $this->breadcrumb = [];
        $this->subTitle = '列表';


        $this->initData($grid);
        return $grid->html($this->request);
    }

    /**
     * @RequestMapping(path="add")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 17:02
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add()
    {

        $grid = new Grid();
        $this->breadcrumb = [
            [
                'path' => '/users/add',
                'active' => 'active',
                'name' => '添加'
            ]
        ];
        $this->subTitle = '添加';

        $this->initData($grid);
        return $grid->html($this->request);
    }

    /**
     * @RequestMapping(path="edit")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 17:02
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit()
    {
        $grid = new Grid();
        $this->breadcrumb = [
            [
                'path' => '/users/edit',
                'active' => 'active',
                'name' => '修改'
            ]
        ];
        $this->subTitle = '修改';

        $this->initData($grid);
        return $grid->html($this->request);
    }
}