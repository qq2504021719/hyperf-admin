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

    public function __construct(HyperfAdminModel $model)
    {
        parent::__construct($model);
    }


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
    private function setSearchHtml(RequestInterface $request)
    {
        $params = $request->all();
        $page = $this->arrIsKey($params,'page',1);
        $paginate = $this->arrIsKey($params,'paginate',10);

        $id = $this->getID();

        $htmls = '';
        if(count($this->searchs))
        {
            // html开始
            $htmls = '<div class="card"><div class="card-body"><form method="get" id="'.$id.'" action="">';


            // 隐藏域内容
            $htmls .= '<input name="paginate" value="'.$paginate.'" type="hidden"><input name="page" value="'.$page.'" type="hidden">';

            $i = 0;
            foreach ($this->searchs as $k=>$v)
            {

                // 设置默认值
                $v->data = $this->arrIsKey($params,$v->name,'');

                // 查询条件处理
                $this->model = $v->queryInit($this->model);

                // html处理
                if($i == 0) $htmls .= '<div class="row">';
                $htmls .= $v->getHtml();
                $i++;
                if($i == 3 || (count($this->searchs)-1) == $k)
                {
                    $i = 0;
                    $htmls .= '</div>';
                }

            }

            // html结束
            $htmls .= '<button type="button" onclick="getElements('."'".$id."'".')" class="btn btn-primary float-right">查询</button></form></div></div>';

            // script
            $htmls .= <<<EOT
            <script>
/**
* 获取对应form里面的值
 * @param formId
*/            
function getElements(formId) {  
  var form = document.getElementById(formId);  
  var str = '';
  // var elements = new Array();  
  var tagElements = form.getElementsByTagName('input');  
  for (var j = 0; j < tagElements.length; j++){ 
     // elements.push(tagElements[j].valueOf()); 
     console.log(tagElements[j].name);
     console.log(tagElements[j].value);
     var name = tagElements[j].name;
     var value = tagElements[j].value;
     if(str == '')
     {
         str += name+"="+value;
     }
     else 
     {
         str += "&"+name+"="+value;
     }
  } 
  viewFaRe(str,2);
}  
</script>
EOT;

        }
        $this->searchHtml = $htmls;
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
            'breadcrumb' => $this->breadcrumb
        ]);
        $this->html .= $html;
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
            'searchHtml' => $this->searchHtml,
            'fields' => $this->fields,
            'rows' => $this->rows,
            'pageHtml' => $this->pageHtml
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
        // 头部信息
        $this->contentHeader();
        // 搜索内容初始化
        $this->setSearchHtml($request);
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