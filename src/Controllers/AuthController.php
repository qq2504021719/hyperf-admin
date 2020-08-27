<?php
declare(strict_types=1);
namespace Pl\HyperfAdmin\Controllers;
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/6/24
 * Time: 11:14
 */

use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;
use Pl\HyperfAdmin\Controllers\HyperfAdminController;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\AdminUsers;
use Pl\HyperfAdmin\Repository\AESRepository;
use Pl\HyperfAdmin\Repository\AuthRepository;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\Success;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Class AuthController
 * @package Pl\HyperfAdmin\Controllers
 * @Controller(prefix="/admin/auth")
 */
class AuthController extends HyperfAdminController
{
    use Functions;
    /**
     * @RequestMapping(path="")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 11:58
     */
    public function loginView()
    {
        $data = [];
        $data['msg'] = '';
        return $this->loginHtml($data);
    }

    /**
     * 登录页共用方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 13:29
     * @param $data
     * @return mixed
     */
    private function loginHtml($data)
    {
        $params = $this->request->all();
        $data['msg'] = $this->arrIsKey($params,'msg');
        $data['url'] = $this->getUrl('auth/login');
        return ViewRepository::viewInitLineCom('login',$data);
    }

    /**
     * 登录
     * @RequestMapping(path="login")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 11:17
     * @return array
     */
    public function login()
    {
//        $this->verify([
//            'name' => 'required',
//            'password' => 'required'
//        ],[
//            'name.required' => '账号不能为空',
//            'password.required' => '密码不能为空'
//        ]);
        $is = true;
        $msg = '';

        $data = $this->request->all();
        $username = $this->arrIsKey($data,'username');
        $password = $this->arrIsKey($data,'password');

        if($username && $password)
        {
            $userData = [];
            $userData = AdminUsers::query()->where('username',$username)->first();

            // 用户不存在
            if($userData)
            {
                // 密码验证
                $passwordDe = AESRepository::decrypt($this->arrIsKey($userData,'password'));
                if($password != $passwordDe)
                {
                    $msg = '密码错误';
                }
                else
                {
                    // 存储到session
                    $this->session->set('user',$userData);
                    $is = false;
                }
            }
            else
            {
                $msg = '账号密码错误';
            }
        }
        else
        {
            $msg = '账号密码不能为空';
        }

        
        if($is)
        {
            return $this->response->redirect($this->getUrl(StateRepository::URL_LOGIN.'?msg='.$msg));
        }
        return $this->response->redirect($this->getUrl(config('hyperf-admin.login_url')));
    }

    /**
     * 退出
     * @RequestMapping(path="out")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 14:20
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function out()
    {
        $this->session->set('user','');
        return $this->response->redirect($this->getUrl(StateRepository::URL_LOGIN));
    }

    /**
     * 用户信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 11:17
     * @return array
     */
    public function userinfo()
    {
        $user = AuthRepository::user($this->session);
        return $user;
    }

}