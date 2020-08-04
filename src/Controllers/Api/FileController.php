<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/4
 * Time: 14:50
 */

namespace Pl\HyperfAdmin\Controllers\Api;


use Pl\HyperfAdmin\Controllers\HyperfAdminController;
use Pl\HyperfAdmin\Repository\CommonRepository;
use Pl\HyperfAdmin\Repository\Success;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class HomeController
 * @package Pl\HyperfAdmin\Controllers\Api
 * @Controller(prefix="/admin/api")
 */
class FileController extends HyperfAdminController
{
    /**
     * 图片上传
     * @RequestMapping(path="img_upload")
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/6/23
     * Time: 13:24
     * @return array
     * @throws \OSS\Core\OssException
     */
    public function img_upload()
    {

        $request = $this->request;
        $file = $request->file('file_data');
        $is = $request->input('is',1);
        // 文件上传失败
        if($file == null || !$file->isValid())
        {
            return Success::success(Success::admin_upload_error);
        }
        // 验证文件大小
        if($file->getSize() > 5242880)
        {
            return Success::success(Success::admin_img_up_size);
        }

        $commonRepository = new CommonRepository();
        $data = $commonRepository->img_upload($request,$is,'file_data');

        return Success::success(Success::success,$data);
    }
}