<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/28
 * Time: 11:26
 */

namespace Pl\HyperfAdmin\Repository;

use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Lib\Functions;

class ExcelZipRepository
{
    use Functions;

    private $query;      // 查询query
    private $name;       // 压缩文件名称
    private $path;       // 存储目录
    private $excel_name;        // excel名称
    private $count;      // 总条数
    private $paginate;   // 每个sheet数量
    private $offset = 0; // 偏移量
    private $ex = 'xlsx'; // 后缀 xlsx csv

    public function __construct($path,$query = '',$name,$paginate=10000)
    {
        $this->path = 'storage/download/excel/'.$path;
        $this->query = $query;
        $query_count = $query;
        $this->count = $query?$query_count->count():0;
        $this->excel_name = $name;
        $this->paginate = $paginate;
    }

    /**
     * excel单元格等号处理
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/11/3
     * Time: 20:11
     * @param $name
     * @return string
     */
    static public function ExcelInitEs($str)
    {
        if(0 === strpos($str,'='))
        {
            return "'".$str;
        }
        return $str;
    }

    /**
     * 分页查询数据
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/11/1
     * Time: 13:34
     * @param RequestInterface $request
     * @param $callback
     * @param int $type 1内部处理 2返回
     * @return array
     */
    public function excel_init(RequestInterface $request,$callback,$type = 1)
    {
        $page = $request->input('page_excel',1);
        $page = $page-1;

        $excel_count = $this->count;
        $paginate = $this->paginate;
        $offset = $page*$excel_count;
        $count_page = ceil($excel_count/$paginate);

        $queryC = $this->query;
        // 验证是否有数据
        $data = $queryC->offset(($page*$paginate+$offset))->limit($paginate)->count();
        if($data == 0)
        {
            $re = ['url'=>'','count'=>$this->count,'count_page'=>$count_page,'msg'=>'无数据'];
        }
        else
        {
            $this->offset = $offset;    // 偏移量
            $this->excel_name = $this->excel_name;
            // 数据导出
            $this->excel($callback);
            $re = ['url'=>$this->get_file_url(),'count'=>$this->count,'msg'=>'','count_page'=>$count_page];
        }

        return $re;
    }


    /**
     * 数组补空，避免导出报错
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/11/1
     * Time: 13:51
     * @param $data
     * @return mixed
     */
    public function addNull($data)
    {
        $numMax = 0;
        if(count($data))
        {
            foreach ($data as $v)
            {
                $num = count($v);
                if($num>$numMax) $numMax = $num;
            }

            foreach ($data as $k=>$v)
            {
                for($i=0;$i<$numMax;$i++)
                {
                    if(!isset($v[$i])) $data[$k][$i] = ' ';
                }
            }
        }

        return $data;
    }

    /**
     * 数据查询
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/5/22
     * Time: 13:34
     * @param $callback
     * @param $excel
     * @return mixed
     */
    private function excel_sheet($callback,$excel)
    {
        $paginate = $this->paginate;
        $count = $this->count;
        $offset = $this->offset;
        for($i = 0; $i < ceil($count/$paginate);$i++)
        {
//            $this->log_hyperfadmin('$i='.$i.'|$count='.$count.'|$paginate='.$paginate);
            $data = $this->query->offset(($i*$paginate+$offset))->limit($paginate)->get();
            if(count($data))
            {
                $re = $callback($data);
                // 不是第一页的情况删除表头
                if($i != 0)
                {
                    unset($re[0]);
                }
                $excel->data($re);
            }
            if($i == 100)
            {
                return $excel;
            }
        }
        return $excel;
    }

    /**
     * 输出导出
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/9
     * Time: 13:32
     * @param $callback
     */
    private function excel($callback)
    {
        ini_set("memory_limit","1024M");
        $name = $this->excel_name;
        $count = $this->count;
        $config   = ['path' => __DIR__.'/../../../../../public/'.$this->path];
        $excel  = new \Vtiful\Kernel\Excel($config);

        $excel->fileName($this->excel_name.'.xlsx', 'sheet1');
        $excel = $this->excel_sheet($callback,$excel);
        $filePath = $excel->output();
    }

    /**
     * 获取excel文件路径
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/9/20
     * Time: 17:07
     * @return string
     */
    private function get_file_url()
    {
        return $this->getPublic().$this->path.$this->excel_name.'.'.$this->ex;
    }
}