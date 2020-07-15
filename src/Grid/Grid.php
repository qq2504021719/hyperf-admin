<?php
namespace Pl\HyperfAdmin\Grid;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/15
 * Time: 14:23
 */

class Grid extends HyperfAdmin
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 头部信息
     * 标题 副标题
     * 快捷导航
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:33
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function contentHeader()
    {
        // 面包屑初始化
        $this->breadcrumbInit();
//        $html = $this->render->render('content.header',);

        $html = ViewRepository::viewInitLineCom('content.header',[
            'title' => $this->title,
            'subTitle' => $this->subTitle,
            'breadcrumb' => $this->breadcrumb
        ]);

        return $html;
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
        $html = '';

        $contentHeaderHtml = $this->contentHeader();


        $html .= $contentHeaderHtml;

        return ViewRepository::viewInitLine($request,$html);
    }
}