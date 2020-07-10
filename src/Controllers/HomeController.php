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

//        $blade = new BladeInstance(__DIR__.'/../../storage/view/',BASE_PATH.'/runtime/view/');
//        return $blade->render('index',$data);

        return $this->render->render('index',$data);
    }
}