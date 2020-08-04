<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/6/23
 * Time: 10:05
 */

namespace Pl\HyperfAdmin\Repository;


class Success
{
    const info = 202;
    const code_success = 200;
    const code_sign_error = 201;        // 授权异常


    const success = 200;
    const auth = 201;
    const params = 215;
    const sms_null = 216;
    const sms_max = 217;
    const sms_verify = 218;
    const user_register = 219;
    const user_null = 220;
    const user_re = 221;
    const admin_upload_error = 222;
    const admin_img_up_size = 223;
    const user_bb_er_error = 234;
    const user_jd_error = 235;
    const user_jp_state_2 = 236;
    const user_jp_day_error = 237;
    const user_jp_get_u_jp_c_id = 238;
    const user_jp_complete = 239;
    const user_jp_friend_error = 239;
    const user_jp_browse_error = 240;
    const is_user_prize_error = 241;
    const is_user_prize_re = 242;

    const tencent_sign_error = 0;


    private static $msg_data = [
        self::success                               => '成功',
        self::auth                                  => '授权异常',
        self::params                                => '参数异常',
        self::sms_null                              => '手机号不能为空',
        self::sms_max                               => '请明日再试',
        self::sms_verify                            => '短信验证失败',
        self::user_register                         => '请填写真实信息',
        self::user_null                             => '用户不存在',
        self::user_re                               => '用户已注册',
        self::admin_upload_error                    => '请上传文件',
        self::admin_img_up_size                     => '图片不能大于5MB',
        self::user_bb_er_error                      => '请填写真实信息',
        self::user_jd_error                         => '用户信息查询失败',
        self::user_jp_state_2                       => '用户有待抽奖的城市',
        self::user_jp_day_error                     => '每天只能领取一次',
        self::user_jp_get_u_jp_c_id                 => '获取用户城市id',
        self::user_jp_complete                      => '已全部完成',
        self::user_jp_friend_error                  => '分享好友每天只能领取2次',
        self::user_jp_browse_error                  => '每种商品每天只能领取一次',
        self::is_user_prize_error                   => '没有抽奖资格',
        self::is_user_prize_re                      => '用户重复抽奖',

        self::tencent_sign_error                    => '回调签名验证错误',
    ];

    /**
     * 获取状态msg
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2019/8/20
     * Time: 11:57
     * @param $k
     * @return mixed|string
     */
    static function get_msg($k)
    {
        $data = self::$msg_data;
        if(isset($data[$k]))
        {
            return $data[$k];
        }
        else
        {
            return '异常';
        }
    }

    /**
     * 返回方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/23
     * Time: 10:16
     * @param int $code
     * @param array $data
     * @param string $msg
     * @return array
     */
    static function success($code = 200,$data = [],$msg = '')
    {
        return [
            'code' => $code,
            'msg' => $msg?$msg:self::get_msg($code),
            'data' => $data,
        ];
    }
}