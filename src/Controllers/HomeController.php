<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/9
 * Time: 16:07
 */

namespace Pl\HyperfAdmin\Controllers;


use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers
 * @Controller(prefix="/admin")
 */
class HomeController extends HyperfAdminController
{
    /**
     * Created by PhpStorm.
     * @RequestMapping(path="index")
     * User: EricPan
     * Date: 2020/7/9
     * Time: 17:36
     * @return array
     */
    public function index()
    {
        $data = [
            'name' => 'Hyperf'
        ];

        return $this->render->render('index',$data);
    }
}