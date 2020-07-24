<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 10:51
 */

namespace Pl\HyperfAdmin\Grid;

use Pl\HyperfAdmin\Lib\Functions;
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
     * 字段html
     * @var
     */
    private $html;

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
     * @param $data
     */
    public function setHtml($data)
    {
        $strHtml = '';
        $str = $this->arrIsKey($data,$this->name);
        switch ($this->type)
        {
            case 'string':
                $strHtml = ViewRepository::viewInitLineCom('content.string',[
                    'data' => $str,
                ]);
                break;
            case 'image':
                $strHtml = ViewRepository::viewInitLineCom('content.image',[
                   'path' => $this->imgPath==""?$str:$this->imgPath.$str,
                   'widht' => $this->imgWidht,
                   'height' => $this->imgHeight
                ]);
                break;
        }
        unset($str);
        $this->html = $strHtml;
        return $this;
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

}