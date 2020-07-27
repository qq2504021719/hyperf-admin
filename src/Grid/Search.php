<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/24
 * Time: 10:21
 */

namespace Pl\HyperfAdmin\Grid;


use MongoDB\Driver\Query;
use Pl\HyperfAdmin\Repository\StateRepository;
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


    /**
     * select2数据
     * @var
     */
    private $select2Data;

    public function __construct($name,$label,$con = '=',$data = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->con = $con;
        $this->data = $data;
    }

    /**
     * select2数据设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/27
     * Time: 17:38
     * @param $data
     * @return $this
     */
    public function option($data)
    {
        $this->select2Data = $data;
        return $this;
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
            case StateRepository::SEARCH_LIKE:
                if($this->data) {
                    $query->where($this->name,'like',"%".$this->data."%");
                }
                break;
            case StateRepository::SEARCH_EQUAL:
                if($this->data) $query->where($this->name,$this->data);
            case StateRepository::SEARCH_NOT_EQUAL:
                if($this->data) $query->where($this->name,'<>',$this->data);
                break;
            case StateRepository::SEARCH_G_THAN:
                if($this->data) $query->where($this->name,'>',$this->data);
            case StateRepository::SEARCH_E_THAN:
                if($this->data) $query->where($this->name,'<',$this->data);
            case StateRepository::SEARCH_TIME_BETWEEN:
                if(is_array($this->data) && count($this->data) && $this->data[0] && $this->data[1]) $query->whereBetween($this->name,$this->data);
                break;
            case StateRepository::SEARCH_SELETE2:
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
            case StateRepository::SEARCH_LIKE:
                $html = $this->getTextHtml();
                break;
            case StateRepository::SEARCH_EQUAL:
                $html = $this->getTextHtml();
                break;
            case StateRepository::SEARCH_NOT_EQUAL:
                $html = $this->getTextHtml();
                break;
            case StateRepository::SEARCH_G_THAN:
                $html = $this->getTextHtml();
                break;
            case StateRepository::SEARCH_E_THAN:
                $html = $this->getTextHtml();
                break;
            case StateRepository::SEARCH_TIME_BETWEEN:
                $html = $this->getTimeBetween();
                break;
            case StateRepository::SEARCH_SELETE2:
                $html = $this->getSelect2Html();
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

    /**
     * 时间区间html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/27
     * Time: 14:59
     * @return mixed
     */
    private function getTimeBetween()
    {
        $strHtml = ViewRepository::viewInitLineCom('content.search.timebetween',[
            'name' => $this->name,
            'label' => $this->label,
            'data' => $this->data,
            'place' => '请选择'.$this->label.'的开始时间 ~ 结束时间',
        ]);
        return $strHtml;
    }

    /**
     * select2选择框html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/27
     * Time: 17:41
     * @return mixed
     */
    private function getSelect2Html()
    {
        $strHtml = ViewRepository::viewInitLineCom('content.search.select2',[
            'name' => $this->name,
            'label' => $this->label,
            'data' => $this->data,
            'option' => $this->select2Data,
            'place' => '请选择'.$this->label,
        ]);
        return $strHtml;
    }
}