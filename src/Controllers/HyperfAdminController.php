<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/9
 * Time: 17:38
 */

namespace Pl\HyperfAdmin\Controllers;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Pl\HyperfAdmin\Form\Form;
use Pl\HyperfAdmin\Grid\Grid;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Repository\ExcelZipRepository;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\Success;
use Pl\HyperfAdmin\Repository\TemplateEngineRepository;
use Psr\Container\ContainerInterface;

/**
 * Class HyperfAdminController
 * @package Pl\HyperfAdmin\Controllers
 */
abstract class HyperfAdminController
{
    protected $title = '';

    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * 自定义模板解析
     * @Inject
     * @var TemplateEngineRepository
     */
    protected $render;

    /**
     * @Inject
     * @var \Hyperf\Contract\SessionInterface
     */
    protected $session;

    /**
     * 副标题
     * @var string
     */
    protected $subTitle = '';

    /**
     * 面包屑
     * @var array
     */
    protected $breadcrumb = [];


    /**
     * 路由前缀拼接
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 10:55
     * @param $url
     * @return string
     */
//    public function getUrl($url)
//    {
//        return '/'.config('hyperf-admin.route.prefix').'/'.$url;
//    }


    /**
     * 初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 16:09
     * @param $object
     */
    protected function initData(HyperfAdmin $object)
    {
        $object->title = $this->title;
        $object->subTitle = $this->subTitle;
        $object->breadcrumb = $this->breadcrumb;
        $object->request = $this->request;
        $object->session = $this->session;
        $object->route = $this->fPath;
    }

    /**
     * grid初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 15:30
     * @param Grid $grid
     * @param $met
     * @return mixed
     */
    protected function gridInit(Grid $grid,$met)
    {
        $this->initData($grid);

        switch ($met)
        {
            case StateRepository::GRID_LIST:
                return $grid->html();
                break;
            case StateRepository::GRID_EXCEL:
                return $grid->getQuery();
                break;
        }

        return $grid;
    }

    /**
     * form初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 15:21
     * @param Form $form
     * @param $met
     * @return Form|\Psr\Http\Message\ResponseInterface
     */
    protected function formInit(Form $form,$met)
    {
        $form->met = $met;

        $this->initData($form);

        switch ($met)
        {
            case StateRepository::FORM_EDIT:
                return $form->html();
                break;
            case StateRepository::FORM_EDIT_SAVE:
                $form->verify();
                return $form;
                break;
            case StateRepository::FORM_ADD:
                return $form->html();
                break;
            case StateRepository::FORM_ADD_SAVE:
                $form->verify();
                return $form;
                break;
        }

        return $form;
    }

    /**
     * 面包屑初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/25
     * Time: 11:32
     * @param $path
     * @param int $type
     */
    public function breadcrumbInit($path,$type = 1)
    {
        $url = $type==1?StateRepository::URL_EDIT:StateRepository::URL_ADD;
        $str = $type==1?'编辑':'添加';

        $this->breadcrumb = [
            [
                'path' => $path.'/'.$url,
                'active' => 'active',
                'name' => $str
            ]
        ];
        $this->subTitle = $str;
    }

    /**
     * 导出初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 16:11
     * @param $query
     * @param $name
     * @param $callback
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function excelInit($query,$name,$callback)
    {
        $request = $this->request;
        /**
         * 创建对象
         */
        $excel = new ExcelZipRepository('',$query,$name);

        /**
         * 导出初始化
         */
        $re = $excel->excel_init($request,function ($data) use($callback){
            return $callback($data);
        });

        return $this->response->json(Success::success(Success::success,$re));
    }

    /**
     * 页面提示
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/25
     * Time: 14:31
     * @param $str
     * @param string $type
     * @param string $title 标题
     */
    public function setToastr($str, $type = 'success',$title = '')
    {
        $this->session->set(StateRepository::TOASTR_NAME,[
            'str' => $str,
            'type' => $type,
            'title' => $title
        ]);
    }
}