<?php
namespace Pl\HyperfAdmin\Form;

use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\ViewRepository;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/30
 * Time: 14:02
 */

class Form extends HyperfAdmin
{
    use Functions;
    /**
     * 字段集合
     * @var array
     */
    private $forms = [];

    /**
     * 字段集合
     * @var array
     */
    private $fileds = [];

    /**
     * 类型
     * 编辑 添加
     * @var string
     */
    public $met = '';

    /**
     * formHtml
     * @var string
     */
    private $formHtml = '';

    public function __construct(HyperfAdminModel $model)
    {
        parent::__construct($model);
    }


    /**
     * 字段构造
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:24
     * @param $name
     * @param $label
     * @param string $type
     * @return FieldForm
     */
    public function field($name,$label,$type = StateRepository::FORM_TEXT)
    {
        $field = new FieldForm($name,$label,$type);
        $field->themeColor = $this->themeColor;
        $this->forms[$name] = $field;
        $this->fileds[] = $name;
        return $field;
    }

    /**
     * 查询数据初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:30
     */
    private function dataInit()
    {
        // 编辑的状态才查询数据、初始化
        if($this->met === StateRepository::FORM_EDIT)
        {
            $id = $this->request->input('id','');
            $data = $this->model->where('id',$id)->first();
            if($data)
            {
                foreach ($this->fileds as $v)
                {
                    $fieldData = $this->arrIsKey($data,$v);
                    if($fieldData)
                    {
                        $this->forms[$v]->data = $fieldData;
                    }
                }
            }
        }
    }

    /**
     * 字段内容初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:40
     */
    private function fieldHtmlInit()
    {
        $this->formHtml .= '<div class="row"><div class="col-md-2"></div><div class="col-md-8">';
        foreach ($this->forms as $fieldForm)
        {
            $this->formHtml .= $fieldForm->getHtml();
        }
        $this->formHtml .= '</div><div class="col-md-2"></div></div>';
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
            'f_path' => $this->route,
            'html' => $this->formHtml,
            'themeColor' => $this->themeColor
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
        // 查询数据初始化
        $this->dataInit();
        // 字段内容初始化
        $this->fieldHtmlInit();
        // form内容初始化
        $this->contentTable();
        // 页面默认script初始化
        $this->contentScriptInit();

        return ViewRepository::viewInitLine($this->request,$this->html);
    }
}