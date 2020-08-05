<?php
declare(strict_types=1);
namespace Pl\HyperfAdmin\Repository;
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/6/24
 * Time: 11:15
 */



use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Model\AdminUsers;

class AuthRepository
{
    /**
     * 用户信息
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 11:27
     * @param SessionInterface $session
     * @return mixed
     */
    public static function user(SessionInterface $session)
    {
        $login = config('hyperf-admin.login');
        if(config('hyperf-admin.login'))
        {
            $user = AdminUsers::query()->find($login);
        }
        else
        {
            $user = $session->get('user');
        }

        return $user;
    }

    /**
     * 添加用户
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 13:56
     * @param RequestInterface $request
     */
    public function addUser(RequestInterface $request)
    {
        $name = $request->input('name');
        $username = $request->input('username');
        $password = $request->input('password');
        $portrait = $request->input('portrait','https://cdn.learnku.com/uploads/images/201802/28/1/Jk8mC7SGI5.jpg!/both/400x400');

        $user = new AdminUsers();
        $user->name = $name;
        $user->username = $username;
        $user->password = AESRepository::encrypt($password);
        $user->avatar = $portrait;
        $user->save();
    }
}