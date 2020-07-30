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
use Pl\HyperfAdmin\Form\Form;
use Pl\HyperfAdmin\Grid\Grid;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\AdminUsers;
use Pl\HyperfAdmin\Repository\ExcelZipRepository;
use Pl\HyperfAdmin\Repository\StateRepository;
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
    use Functions;
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
     * 父级路由
     * @var string
     */
    public $fPath = '/users';
    

    /**
     * 初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 16:09
     * @param $object
     */
    private function initData(HyperfAdmin $object)
    {
        $object->title = $this->title;
        $object->subTitle = $this->subTitle;
        $object->breadcrumb = $this->breadcrumb;
        $object->request = $this->request;
        $object->route = $this->fPath;
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
        $grid = new Grid(new AdminUsers());
        $grid->isIndex = true;
        $this->breadcrumb = [];
        $this->subTitle = '列表';

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

        $this->initData($grid);
        return $grid->html();
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
    private function form($met)
    {
        $form = new Form(new AdminUsers());



        $this->initData($form);
        return $form->html();
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
        $this->breadcrumb = [
            [
                'path' => '/users/edit',
                'active' => 'active',
                'name' => '编辑'
            ]
        ];
        $this->subTitle = '编辑';

        return $this->form('edit');
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
        $request = $this->request;
        $query = AdminUsers::query();

        /**
         * 创建对象
         */
        $excel = new ExcelZipRepository('',$query,'管理员信息');

        /**
         * 导出初始化
         */
        $re = $excel->excel_init($request,function ($data){
            return $this->excelDataInit($data);
        });

        return $this->response->json(Success::success(Success::success,$re));
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
    private function excelDataInit($data)
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

        $grid = new Grid(new AdminUsers());
        $this->breadcrumb = [
            [
                'path' => '/users/add',
                'active' => 'active',
                'name' => '添加'
            ]
        ];
        $this->subTitle = '添加';

        $grid->column('avatar','头像');
        $grid->column('name','昵称');
        $grid->column('username','账号');
        $grid->column('created_at','创建时间');

        $this->initData($grid);
        return $grid->html($this->request);
    }


}