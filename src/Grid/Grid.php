<?php
namespace Pl\HyperfAdmin\Grid;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 14:23
 */

class Grid extends HyperfAdmin
{
    use Functions;

    /**
     * 列集合
     * @var array
     */
    private $columns = [];

    /**
     * 处理字段
     * @var array
     */
    private $fields = [];

    /**
     * 行集合
     * @var array
     */
    private $rows = [];

    /**
     * 搜索集合
     * @var array
     */
    private $searchs = [];

    /**
     * 搜索html
     * @var
     */
    private $searchHtml = '';

    /**
     * 页面内容
     * @var
     */
    private $html = '';

    /**
     *  分页html
     * @var
     */
    private $pageHtml = '';

    /**
     * 查询数据
     * @var
     */
    private $data = [];

    /**
     * 组件显示隐藏
     * export 导出
     * @var array
     */
    private $isShow = [
        'export' => true,
    ];

    /**
     * excel导出url
     * @var string
     */
    public $excelUrl = '';

    /**
     * 查询参数
     * @var RequestInterface
     */
    private $request;

    public function __construct(HyperfAdminModel $model)
    {
        parent::__construct($model);
    }

    /**
     * 组件显示隐藏
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/27
     * Time: 14:20
     */
    public function displayExport(){ $this->isShow['export'] = false;}

    /**
     * 列信息设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 11:04
     * @param $name
     * @param string $label
     * @return Column
     */
    public function column($name,$label = '',$type = 'string')
    {
        $column = new Column($name,$label,$type);

        $this->fields[$name] = $label;
        $this->columns[$name] = $column;
        return $column;
    }

    /**
     * 查询信息设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 10:46
     * @param $name
     * @param $label
     * @param string $con
     * @param string $data
     * @return Search
     */
    public function search($name,$label,$con = '=',$data = '')
    {
        $search = new Search($name,$label,$con,$data);
        $this->searchs[] = $search;
        return $search;
    }

    /**
     * 设置搜索html
     * 设置搜索条件
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 10:56
     * @param RequestInterface $request
     */
    private function searchInit(RequestInterface $request)
    {
        $searchHtml = new SearchHtml();
        $re = $searchHtml->htmlInit($request,$this->model,$this->searchs);
        $this->model = $this->arrIsKey($re,'model');
        $this->searchHtml = $this->arrIsKey($re,'html');
    }

    /**
     * 数据查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 11:56
     * @param RequestInterface $request
     */
    private function getData(RequestInterface $request)
    {
        $params = $request->all();
        $page = $this->arrIsKey($params,'page',1);
        $paginate = $this->arrIsKey($params,'paginate',10);

        if(count($this->fields))
        {
            $modelQuery = '';
            $modelQuery = $this->model;

            // 查询记录总数
            $count = $modelQuery->count();

            // 分页数据
            $this->pageHtml = new Page($page,$paginate,$count);


            // 查询数据
            $this->data = $modelQuery->limit($paginate)->offset(($page-1)*$paginate)->get();

            unset($modelQuery);
        }

    }

    /**
     * 表格内容数据格式化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/17
     * Time: 11:38
     */
    private function tableDataInit()
    {
        if(count($this->data))
        {
            foreach ($this->data as $k=>$v)
            {
                $columns = [];
                $data = [];
                // 处理一行里面每一列的数据
                foreach ($this->fields as $key=>$value)
                {
                    $column = '';
                    $column = $this->columns[$key];
                    // 设置html
                    $column->setHtml($v);
                    $this->columns[$key] = $column;
                    // 列html存储数组
                    $data[$key] = $column->getHtml();
                }
                $row = new Row();
                $row->html = $data;
                $this->rows[$k] = $row;
            }
        }
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
    private function contentHeader()
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
     * 获取下载url
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 11:11
     * @return string
     */
    private function getExcelUrl()
    {
        $params = $this->request->all();
        $get = http_build_query($params);

        return config('hyperf-admin.app_host').$this->getUrl(substr($this->route,1,strlen($this->route)).'/excel?'.$get);
    }

    /**
     * 导出按钮excel
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/28
     * Time: 13:30
     * @return mixed
     */
    private function getExcelHtml()
    {
        $html = ViewRepository::viewInitLineCom('content.excel',[
            'excel_url' => $this->getExcelUrl(),
        ]);
        return $html;
    }

    /**
     * 表格内容
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 11:06
     */
    private function contentTable()
    {
        $html = ViewRepository::viewInitLineCom('content.table',[
            'excelHtml' => $this->getExcelHtml(),
            'searchHtml' => $this->searchHtml,
            'fields' => $this->fields,
            'rows' => $this->rows,
            'pageHtml' => $this->pageHtml,
            'isShow' => $this->isShow

        ]);
        $this->html .= $html;
        $this->fields = [];
        $this->rows = [];
        $this->pageHtml = [];
    }

    /**
     * html页面
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:34
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function html(RequestInterface $request)
    {
        $this->request = $request;
        // 头部信息
        $this->contentHeader();
        // 搜索内容初始化
        $this->searchInit($request);
        // 表格内容查询
        $this->getData($request);
        // 表格内容数据格式化
        if(count($this->data)) $this->tableDataInit();
        // 表格分页html初始化
        if($this->pageHtml) $this->pageHtml->pageInit();
        // 表格内容
        $this->contentTable();

        return ViewRepository::viewInitLine($request,$this->html);
    }
}