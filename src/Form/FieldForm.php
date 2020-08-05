<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/3
 * Time: 15:07
 */

namespace Pl\HyperfAdmin\Form;


use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\ViewRepository;

class FieldForm
{
    /**
     * 字段名称
     * @var string
     */
    public $name = '';

    /**
     * 默认值
     * @var string
     */
    public $data = '';

    /**
     * 默认值
     * @var string
     */
    public $label = '';

    /**
     * 输入框类型
     * 默认文本
     * @var string
     */
    public $type = '';

    /**
     * 错误提示
     * @var string
     */
    public $errorStr = '';

    /**
     * 主题色
     * @var string
     */
    public $themeColor = '';

    /**
     * 是否必填
     * @var bool
     */
    private $isRequest = false;

    /**
     * 提示
     * @var string
     */
    private $help = '';


    public function __construct($name,$label,$type = StateRepository::FORM_TEXT)
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
    }

    /**
     * 获取html
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:40
     * @return mixed|string
     */
    public function getHtml()
    {
        $html = '';
        switch ($this->type)
        {
            case StateRepository::FORM_TEXT:
                $html = $this->getTextHtml();
                break;
            case StateRepository::FORM_UPLOAD:
                $html = $this->getUploadHtml();
                break;
        }

        return $html;
    }

    /**
     * 获取texthtml内容
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:39
     * @return mixed
     */
    private function getTextHtml()
    {
        $html = ViewRepository::viewInitLineCom('content.form.text',[
            'name' => $this->name,
            'label' => $this->label,
            'data' => $this->data,
            'placeholder' => '请输入值',
            'isRequest' => $this->isRequest,
            'errorStr' => $this->errorStr,
        ]);
        return $html;
    }

    /**
     * 获取Upload-html内容
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:39
     * @return mixed
     */
    private function getUploadHtml()
    {
        $data = [];
        if($this->data)
        {
            $data[] = $this->data;
        }

        $html = ViewRepository::viewInitLineCom('content.form.upload',[
            'name' => $this->name,
            'label' => $this->label,
            'data' => $data,
            'valueData' => $this->data,
            'placeholder' => '请上传文件',
            'isRequest' => $this->isRequest,
            'errorStr' => $this->errorStr,
            'themeColor' => $this->themeColor,

        ]);
        return $html;
    }
}