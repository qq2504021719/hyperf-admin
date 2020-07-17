<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 13:47
 */

namespace Pl\HyperfAdmin\Grid;


class Row
{
    /**
     * 行html
     * @var
     */
    public $html = [];

    /**
     * 每一行
     * @var
     */
    private $column;

    /**
     * 设置
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 13:50
     * @param $data
     */
    public function setColumn($data)
    {
        $this->column = $data;
    }

    /**
     * 获取
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 13:51
     * @return Column
     */
    public function getColumn():array
    {
        return $this->column;
    }
}