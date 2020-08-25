<?php
namespace Pl\HyperfAdmin\Controllers\Api;

use Pl\HyperfAdmin\Controllers\HyperfAdminController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\AdminUsers;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers\Api
 * @Controller(prefix="/ticket/admin/api")
 */
class adminApiController extends HyperfAdminController
{
    use Functions;
    /**
     * 列表页
     * @RequestMapping(path="admin_list")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/15
     * Time: 14:36
     * @return \Psr\Http\Message\ResponseInterface
     *
     * {
        "current_page": 1,
        "data": [],
        "first_page_url": "/?page=1",
        "from": 1,
        "last_page": 12289,
        "last_page_url": "/?page=12289",
        "next_page_url": "/?page=2",
        "path": "/",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 122884
        }
     */
    public function adminList()
    {
        $params = $this->request->all();
        $q = $this->arrIsKey($params,'q');
        $page = $this->arrIsKey($params,'page',1);
        $paginate = $this->arrIsKey($params,'paginate',10);

        $model = AdminUsers::query();

        if($q)
        {
            $model->where('name','like',"%".$q."%");
        }
        $model->select('id','name as text');

        $data = $model->paginate($paginate);
        return $data;
    }
}