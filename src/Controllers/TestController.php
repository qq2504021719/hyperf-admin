<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/9
 * Time: 16:07
 */

namespace Pl\HyperfAdmin\Controllers;


use duncan3dc\Laravel\BladeInstance;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\View\Engine\BladeEngine;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers
 * @Controller(prefix="/admin")
 */
class TestController extends HyperfAdminController
{

    /**
     * Created by PhpStorm.
     * @RequestMapping(path="")
     * User: EricPan
     * Date: 2020/7/14
     * Time: 15:02
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function home()
    {
        $data = [];
        return ViewRepository::viewInit($this->request,$this->render,'layouts.layout',$data);
    }

    /**
     * Created by PhpStorm.
     * @RequestMapping(path="testindex")
     * User: EricPan
     * Date: 2020/7/9
     * Time: 17:36
     * @return array
     */
    public function testindex()
    {
        $data = [
            'name' => '首页'
        ];


        return ViewRepository::viewInit($this->request,$this->render,'index',$data);
    }

    /**
     * Created by PhpStorm.
     * @RequestMapping(path="testindex1")
     * User: EricPan
     * Date: 2020/7/9
     * Time: 17:36
     * @return array
     */
    public function testindex1()
    {
        $data = [
            'name' => '首页'
        ];
        

        return ViewRepository::viewInit($this->request,$this->render,'index',$data);
    }

    /**
     * @RequestMapping(path="test")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/14
     * Time: 13:56
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function test()
    {
        $data = [
            'name' => 'Test'
        ];

        return ViewRepository::viewInit($this->request,$this->render,'test',$data);
    }

    /**
     * @RequestMapping(path="test1")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/14
     * Time: 13:56
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function test1()
    {
        $data = [
            'name' => 'Test1'
        ];

        return ViewRepository::viewInit($this->request,$this->render,'test1',$data);
    }
}