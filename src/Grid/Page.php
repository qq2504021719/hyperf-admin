<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 14:25
 */

namespace Pl\HyperfAdmin\Grid;


use Pl\HyperfAdmin\Repository\ViewRepository;

class Page
{
    /**
     * 页码
     * @var
     */
    public $page;

    /**
     * 每页数量
     * @var
     */
    public $paginate;

    /**
     * 记录总数
     * @var
     */
    public $count;

    /**
     * 合计多少页
     * @var
     */
    public $pageNum;

    /**
     * 分页前后步长
     * @var
     */
    public $step = 3;

    /**
     * 当前页第多少条开始
     * @var
     */
    public $start;

    /**
     * 当前页多少条结束
     * @var
     */
    public $end;


    /**
     * 分页html
     * @var
     */
    public $html;


    public function __construct($page,$paginate,$count)
    {
        $this->page = $page;
        $this->paginate = $paginate;
        $this->count = $count;
    }

    /**
     * 初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:37
     */
    public function pageInit()
    {
        // 初始化页面分页开始结束数
        $this->startEnd();
        // 分页数据初始化
        $this->pageNumInit();
    }

    /**
     * 分页数据初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:45
     */
    private function pageNumInit()
    {
        $this->pageNum = ceil($this->count/$this->paginate);
        $this->html = ViewRepository::viewInitLineCom('content.page',[
            'pageHtml' => $this
        ]);
    }

    /**
     * 初始化页面分页开始结束数
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 14:36
     */
    private function startEnd()
    {
        $start = ($this->page-1)*$this->paginate;
        $this->start = $start<=0?1:$start;

        $end = $this->page*$this->paginate;
        $this->end = $end>$this->count?$this->count:$end;
    }
}