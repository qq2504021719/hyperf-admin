<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 10:51
 */

namespace Pl\HyperfAdmin\Grid;

use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * 每一个字段
 * Class Column
 * @package Pl\HyperfAdmin\Grid
 */
class Column
{
    use Functions;

    /**
     * 主题色
     * @var string
     */
    public $themeColor = '';

    /**
     * 行数据
     * @var
     */
    public $data;

    /**
     * 字段名
     * @var
     */
    private $name;

    /**
     * 注释
     * @var
     */
    private $label;

    /**
     * 字段类型
     * string
     * image
     * @var
     */
    private $type = 'string';

    /**
     * 字段排序
     * 是否排序 true 是 false 否
     * @var bool
     */
    private $sort = false;

    /**
     * 字段排序规则
     * ASC 升序 DESC 降序
     * @var
     */
    private $sortOrder = 'DESC';


    /**
     * 自定义显示回调函数
     * @var
     */
    private $callback = '';

    /**
     * 字段html
     * @var
     */
    private $html = '';

    /**
     * 是否显示操作列
     * @var
     */
    public $isActivity = true;
    /**
     * 是否显示操作编辑按钮
     * @var bool
     */
    public $isActivityEdit = true;
    /**
     * 是否显示操作删除按钮
     * @var bool
     */
    public $isActivityDelete = true;

    /**
     * 内容 拉包裹
     * @var string
     */
    private $lab = '';

    /**
     * 图片相关
     * @var
     */
    private $imgWidht;
    private $imgHeight;
    private $imgPath;

    public function __construct($name,$label = '',$type = 'string')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * 排序
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 10:58
     * @param string $order ASC 升序 DESC 降序
     * @return $this
     */
    public function sortable($order = 'DESC')
    {
        $this->sort = true;
        return $this;
    }

    /**
     * 获取是否排序
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:14
     * @return bool
     */
    public function getSort():bool
    {
        return $this->sort;
    }

    /**
     * 设置字段html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 13:34
     */
    public function setHtml()
    {
        $strHtml = '';
        // 对应列html没有设置内容
        if($this->html == '')
        {
            $data = $this->data;
            $str = $this->arrIsKey($data,$this->name);
            switch ($this->type)
            {
                case 'string':
                        $strHtml = $this->stringHtml($str);
                    break;
                case 'image':
                    $strHtml = ViewRepository::viewInitLineCom('content.image',[
                        'path' => $this->imgPath==""?$str:$this->imgPath.$str,
                        'widht' => $this->imgWidht,
                        'height' => $this->imgHeight
                    ]);
                    break;
                case 'activity':
                    $strHtml = $this->activityHtml($this->arrIsKey($data,'id'));
                    break;
            }
            unset($str);
            $this->html = $strHtml;
        }
    }

    /**
     * 操作html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 10:51
     * @param $id
     */
    private function activityHtml($id)
    {
        $html = '';
        if($this->isActivity)
        {
            $html = ViewRepository::viewInitLineCom('content.activity',[
                'isActivityEdit' => $this->isActivityEdit,
                'isActivityDelete' => $this->isActivityDelete,
                'id' => $id,
                'themeColor' => $this->themeColor
            ]);
        }
        return $html;
    }

    /**
     * 字符串html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 11:42
     * @param $html
     * @return string
     */
    private function stringHtml($str)
    {
        // 内容 lab 包裹
        if($this->lab) $str = $this->labHtml($str);

        $strHtml = ViewRepository::viewInitLineCom('content.string',[
            'data' => $str,
        ]);
        return $strHtml;
    }



    /**
     * 图片配置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 16:42
     * @param string $path
     * @param int $widht
     * @param int $height
     */
    public function image($path = '',$widht = 100,$height = 100)
    {
        $this->imgPath = $path;
        $this->imgWidht = $widht;
        $this->imgHeight = $height;
        $this->type = 'image';
        return $this;
    }

    /**
     * 内容设置lab包裹
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 11:47
     * @param string $color
     */
    public function lab($color = ''){
        if(!$color) $color = $this->themeColor;
        $this->lab = $color;
    }

    /**
     * 内容lab html设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 11:48
     * @param $html
     */
    private function labHtml($html)
    {
         $strHtml = ViewRepository::viewInitLineCom('content.lab',[
            'data' => $html,
            'color' => $this->lab
        ]);
        return $strHtml;
    }

    /**
     * 获取html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:00
     * @return string
     */
    public function getHtml():string
    {
        return $this->html;
    }

    /**
     * 获取label
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 13:44
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label?$this->label:$this->name;
    }


    /**
     * 字段排序规则
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:18
     * @return string
     */
    public function getSortOrder():string
    {
        return $this->sortOrder;
    }

    /**
     * 自定义显示
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 11:19
     * @param $callback
     */
    public function display($callback)
    {
        $this->callback = $callback;
    }

    /**
     * 自定义显示HTML
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 11:32
     */
    public function displayHtml()
    {
        $callback = $this->callback;
        if($callback)
        {
            $html = $callback($this->data);
            $strHtml = $this->stringHtml($html);
            $this->html = $strHtml;
        }
    }
}