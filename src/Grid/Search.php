<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/24
 * Time: 10:21
 */

namespace Pl\HyperfAdmin\Grid;


use MongoDB\Driver\Query;
use Pl\HyperfAdmin\Repository\ViewRepository;

class Search
{
    /**
     * 默认值
     * @var array
     */
    public $data = '';

    public $name;

    /**
     * 名称
     * @var string
     */
    public $label = '';

    /**
     * 类型
     * = 等于
     * like 模糊查询
     * <> 不等于
     * > 大于
     * < 小于
     * between 范围
     * @var
     */
    public $con;

    public function __construct($name,$label,$con = '=',$data = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->con = $con;
        $this->data = $data;
    }

    /**
     * 查询初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 10:41
     * @param $query
     * @return mixed
     */
    public function queryInit($query)
    {
        switch ($this->con)
        {
            case 'like':
                if($this->data) {
                    $query->where($this->name,'like',"%".$this->data."%");
                }
                break;
            case '=':
                if($this->data) $query->where($this->name,$this->data);
                break;
        }

        return $query;
    }

    /**
     * 查询html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 10:43
     * @return string|void
     */
    public function getHtml()
    {
        $html = '';
        switch ($this->con)
        {
            case 'like':
                $html = $this->getTextHtml();
                break;
            case '=':
                $html = $this->getTextHtml();
                break;
            case '<>':
                $html = $this->getTextHtml();
                break;
            case '>':
                $html = $this->getTextHtml();
                break;
            case '<':
                $html = $this->getTextHtml();
                break;
        }
        return $html;
    }

    /**
     * 文本html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/24
     * Time: 10:55
     * @return mixed
     */
    private function getTextHtml()
    {
        $strHtml = ViewRepository::viewInitLineCom('content.search.text',[
            'name' => $this->name,
            'label' => $this->label,
            'data' => $this->data,
            'place' => '请输入'.$this->label
        ]);
        return $strHtml;
    }
}