<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/4
 * Time: 14:55
 */

namespace Pl\HyperfAdmin\Repository;


use PDepend\Source\AST\State;
use Pl\HyperfAdmin\Lib\Functions;

class CommonRepository
{
    use Functions;
    
    /**
     * 文件上传 \League\Flysystem\Filesystem
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/23
     * Time: 11:45
     * @param Request $request
     * @param int $is
     * @param string $key
     * @return array
     * @throws \OSS\Core\OssException
     */
    public function img_upload($request,$is = 1,$key = 'file')
    {
        $file =$request->file($key);
        $path = 'public/upload/'.time().mt_rand(1,10000).'.'.$file->getExtension();
        $file->moveTo($path);
        chmod($path,0777);
        if($path)
        {
//            if($is == 1)
//            {
//                // 上传到阿里云oss
//                $path = AliRepository::alibaba_oss($path);
//            }
//            else
//            {
                $path = $this->getHostUrl().$path;
//            }
        }
        return ['path'=>$path];
    }
}