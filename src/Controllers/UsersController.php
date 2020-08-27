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
use App\Controller\Success;
use Hyperf\HttpServer\Annotation\Middleware;
use Pl\HyperfAdmin\Form\Form;
use Pl\HyperfAdmin\Form\FormSave;
use Pl\HyperfAdmin\Grid\Grid;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\AdminUsers;
use Pl\HyperfAdmin\Repository\AESRepository;
use Pl\HyperfAdmin\Repository\ExcelZipRepository;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\ViewRepository;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Pl\HyperfAdmin\Middleware\HyperfAuthMiddleware;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers
 * @Controller(prefix="/admin/users")
 * @Middleware(HyperfAuthMiddleware::class)
 */
class UsersController extends HyperfAdminController
{
    use Functions;
    /**
     * 标题
     * @var string
     */
    public $title = '管理员';

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
     * 父级路由
     * @var string
     */
    public $fPath = '/users';

    /**
     * grid配置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 15:31
     * @param Grid $met
     * @return mixed
     */
    public function grid($met)
    {
        $grid = new Grid(new AdminUsers());
        $grid->displayActivityDel();
        $grid->model->orderBy('id','DESC');
        $grid->isIndex = true;

        $url = $this->getUrl('api/admin_list');
        $grid->search('name','昵称',StateRepository::SEARCH_LIKE);
        $grid->search('created_at','创建时间',StateRepository::SEARCH_TIME_BETWEEN);
        $grid->search('username','角色',StateRepository::SEARCH_SELETE2)->option([
            'admin' => '系统管理员',
            '订单管理员' => '普通管理员'
        ]);
        $grid->search('id','管理员',StateRepository::SEARCH_SELETE2_AJAX)->ajax($url);


        $grid->column('id','ID');
        $grid->column('avatar','头像')->image('',50,50);
        $grid->column('name','昵称')->lab();
        $grid->column('username','账号');
        $grid->column('created_at','创建时间');
//        $grid->column('asder','其他操作')->display(function ($data){
//            $id = $this->arrIsKey($data,'id');
//            return '<button type="button" class="btn btn-primary btn-sm">编辑-'.$id.'</button>';
//        });

        return $this->gridInit($grid,$met);
    }

    /**
     * form设置
     * 编辑-添加字段设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 17:03
     * @param $met
     */
    public function form($met)
    {
        $form = new Form(new AdminUsers());
        $form->met = $met;

        $form->field('avatar','头像',StateRepository::FORM_UPLOAD);
        $form->field('name','昵称')->rule('required',[
            'required' => '昵称不能为空'
        ]);
        $form->field('username','账号');
        $form->field('password','密码');

        return $this->formInit($form,$met);
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
        return $this->indexView($this);
    }

    /**
     * 修改
     * @RequestMapping(path="edit")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 17:02
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function edit()
    {
        return $this->editView($this);
    }

    /**
     * 修改保存
     * @RequestMapping(path="edit_save")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 9:43
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function editSave()
    {

        $that = $this;
        return $this->editSaveView($that,function ($that,$form){
            $id = $that->request->input('id');
            $password = $that->request->input('password');
            /**
             * 查询是否加密密码
             * 本次密码和数据库的不相等
             */
            $data = AdminUsers::query()->where('id',$id)->first();
            if($that->arrIsKey($data,'password') != $password) $form = $that->saveFrontCallback($form);
            return $form;
        });
    }

    /**
     * 添加
     * @RequestMapping(path="add")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 17:02
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function add()
    {
        return $this->addView($this);
    }

    /**
     * 添加保存
     * @RequestMapping(path="add_save")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 9:43
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addSave()
    {
        return $this->addSaveView($this);
    }

    /**
     * 保存前回调
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 14:14
     * @param Form $form
     * @return Form
     */
    public function saveFrontCallback(Form $form)
    {
        $that = $this;
        // 保存前回调
        $form->saveFrontCallback = function ($params) use($that){
            $password = $that->arrIsKey($params,'password');
            $password = AESRepository::encrypt($password);
            $params['password'] = $password;
            return $params;
        };
        return $form;
    }

    /**
     * 导出
     * @RequestMapping(path="excel")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 11:03
     */
    public function excel()
    {
        return $this->excelView($this);
    }

    /**
     * 查询数据处理，格式化组合为导出格式
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 11:31
     * @param $data
     * @return array
     */
    public function excelDataInit($data)
    {
        $rows = [];

        $rows[0] = ['ID','头像','昵称','账号','创建时间'];

        foreach ($data as $v)
        {
            $row = [];

            $row[] = $this->arrIsKey($v,'id');
            $row[] = $this->arrIsKey($v,'avatar');
            $row[] = $this->arrIsKey($v,'name');
            $row[] = $this->arrIsKey($v,'username');
            $row[] = date('Y-m-d H:i:s',strtotime($this->arrIsKey($v,'created_at')));

            $rows[] = $row;
        }

        return $rows;
    }
}