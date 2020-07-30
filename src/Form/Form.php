<?php
namespace Pl\HyperfAdmin\Form;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/30
 * Time: 14:02
 */

class Form extends HyperfAdmin
{

    public function __construct(HyperfAdminModel $model)
    {
        parent::__construct($model);
    }



    /**
     * form内容初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/16
     * Time: 11:06
     */
    private function contentTable()
    {
        $html = ViewRepository::viewInitLineCom('content.form.form',[
            'f_path' => $this->route
        ]);
        $this->html .= $html;


    }

    /**
     * 页面默认script初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 19:28
     */
    private function contentScriptInit()
    {
        // script
        $this->html .= '<script>'.$this->getFPathScript().'</script>';
    }

    /**
     * form html返回
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/30
     * Time: 17:29
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function html()
    {
        // 头部信息
        $this->contentHeader();
        // form内容初始化
        $this->contentTable();
        // 页面默认script初始化
        $this->contentScriptInit();

        return ViewRepository::viewInitLine($this->request,$this->html);
    }
}