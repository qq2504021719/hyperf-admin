<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/6/24
 * Time: 13:44
 */

namespace Pl\HyperfAdmin\Repository;


class AESRepository
{
    /**
     * 加密
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 13:50
     * @param $str
     * @return string
     */
    public static function encrypt($str)
    {
        $aes = new AESDeEnRepository(config('hyperf-admin.aes_key'),config('hyperf-admin.aes_iv'));
        return $aes->encrypt($str);
    }

    /**
     * 解密
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/24
     * Time: 13:50
     * @param $str
     * @return string
     */
    public static function decrypt($str)
    {
        $aes = new AESDeEnRepository(config('hyperf-admin.aes_key'),config('hyperf-admin.aes_iv'));
        return $aes->decrypt($str);
    }
}