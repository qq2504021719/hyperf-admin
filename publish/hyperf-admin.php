<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/9
 * Time: 14:08
 */

return [

    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'Pl\\HyperfAdmin\\Controllers',

//    'middleware' => ['web', 'admin'],
    ],

    /**
     * 登录成功重定向页面
     */
    'login_url' => '/users',

    /**
     * 项目链接
     */
    'app_host' => env('APP_HOST',''),

    /**
     * title
     */
    'name' => 'hyperf-admin',

    /**
     * logo
     */
    'logo' =>'/public/vendor/dist/img/AdminLTELogo.png',

    /**
     * 模板前缀
     */
    'view_template_prefix' => '',

    /**
     * 登录测试
     * 有值表示用这个用户登录
     */
    'login' => '',

    /**
     * AES加密解密 KEY
     */
    'aes_key' => 'asdmkbj861*&^hjg76hgGf',

    /**
     * AES IV
     */
    'aes_iv' => 'ASD&^%&^%BGFRDEH',

    /**
     * 菜单
     */
    'menu' => [
//        [
//            'id' => 7,
//            'name' => 'Test首页',
//            'path' => '/testindex',
//            'icon' => 'fas fa-tachometer-alt',
//            'subset' => []
//        ],
//        [
//            'id' => 1,
//            'name' => 'Test菜单',
//            'path' => '',
//            'icon' => 'fas fa-tachometer-alt',
//            'subset' => [
//                [
//                    'id' => 2,
//                    'f_id' => 1,
//                    'name' => 'Test首页',
//                    'icon' => 'far fa-circle',
//                    'path' => '/testindex1',
//                ],
//                [
//                    'id' => 3,
//                    'f_id' => 1,
//                    'name' => 'Test',
//                    'icon' => 'far fa-circle',
//                    'path' => '/test',
//                ],
//                [
//                    'id' => 4,
//                    'f_id' => 1,
//                    'name' => 'Test1',
//                    'icon' => 'far fa-circle',
//                    'path' => '/test1',
//                ],
//            ],
//        ],
        [
            'id' => 5,
            'name' => '系统',
            'path' => '',
            'icon' => 'fas fa-cog',
            'subset' => [
                [
                    'id' => 6,
                    'f_id' => 5,
                    'name' => '管理员',
                    'icon' => 'fas fa-users',
                    'path' => '/users',
                ]
            ],
        ]
    ]
];