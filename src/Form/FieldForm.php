<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/3
 * Time: 15:07
 */

namespace Pl\HyperfAdmin\Form;


use PDepend\Source\AST\State;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Repository\StateRepository;
use Pl\HyperfAdmin\Repository\ViewRepository;

class FieldForm
{
    use Functions;

    /**
     * 类型
     * 编辑edit 编辑保存edit_save 添加add 添加保存add_save
     * @var string
     */
    public $met = '';

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

    /**
     * select2值
     * @var array
     */
    private $option = [];

    /**
     * 字段验证规则
     * @var string
     */
    public $rule = '';
    /**
     * 验证提示
     * @var array
     */
    public $message = [];

    /**
     * @var string
     */
    private $inputType = '';


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
            case StateRepository::FORM_SELECT:
                $html = $this->getSelectHtml();
                break;
            case StateRepository::FORM_TIME:
                $html = $this->getTimeHtml();
                break;
        }

        return $html;
    }

    /**
     * select2设置值
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/24
     * Time: 11:13
     * @param array|string $data 数组或者url
     */
    public function option($data)
    {
        if(is_array($data))
        {
            $this->option = $data;
        }
        return $this;
    }

    /**
     * 帮助
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/24
     * Time: 17:19
     * @param $data
     * @return $this
     */
    public function help($data)
    {
        $this->help = $data;
        return $this;
    }

    /**
     * 字段验证
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/24
     * Time: 17:42
     * @param $rule
     * @param array $message
     * @return $this
     */
    public function rule($rule,$message = [])
    {
        $this->rule = $rule;
        $this->message = $message;
        return $this;
    }

    /**
     * 默认值
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/25
     * Time: 11:25
     * @param $data
     * @return $this
     */
    public function default($data)
    {
        // 只有添加页面的时候才使用默认值
        if($this->met == StateRepository::FORM_ADD || $this->met == StateRepository::FORM_EDIT_SAVE)
        {

        }

        if(!$this->data && $this->data !== 0)
        {
            $this->data = $data;
        }

        // 或者修改时data没有值
        return $this;
    }


    /**
     * 隐藏表单
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/26
     * Time: 17:10
     * @return $this
     */
    public function hidden()
    {
        $this->setInputType(StateRepository::FORM_INPUT_HIDDEN);

        return $this;
    }

    /**
     * 返回值初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/24
     * Time: 17:21
     * @param $data
     * @return mixed
     */
    private function dataInit($data)
    {
        $data['errorStr'] = $this->errorStr;
        $data['name'] = $this->name;
        $data['label'] = $this->label;
        $data['data'] = $this->data;
        $data['isRequest'] = $this->isRequest;
        $data['help'] = $this->help;
        $data['inputType'] = $this->inputType;
        return $data;
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
        $this->setInputType(StateRepository::FORM_INPUT_TEXT);
        $html = ViewRepository::viewInitLineCom('content.form.text',$this->dataInit([
            'placeholder' => '请输入值',
        ]));
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
    private function getSelectHtml()
    {
        $this->setInputType(StateRepository::FORM_INPUT_HIDDEN);
        $html = ViewRepository::viewInitLineCom('content.form.select',$this->dataInit([
            'option' => $this->option,
            'placeholder' => '请选择',
        ]));
        return $html;
    }

    /**
     * 获取日期html内容
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/3
     * Time: 15:39
     * @return mixed
     */
    private function getTimeHtml()
    {
        $this->setInputType(StateRepository::FORM_INPUT_TEXT);
        $html = ViewRepository::viewInitLineCom('content.form.time',$this->dataInit([
            'placeholder' => '请选择日期',
        ]));
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
        $this->setInputType(StateRepository::FORM_INPUT_FILE);
        $data = [];
        if($this->data)
        {
            $data[] = $this->data;
        }
        $re = $this->dataInit([]);
        $re = array_merge($re,[
            'url' => $this->getUrl('api/img_upload'),
            'data' => $data,
            'valueData' => $this->data,
            'placeholder' => '请上传文件',
            'themeColor' => $this->themeColor,

        ]);
        $html = ViewRepository::viewInitLineCom('content.form.upload',$re);
        return $html;
    }

    /**
     * 设置input类型
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/26
     * Time: 17:23
     * @param $str
     */
    private function setInputType($str)
    {
        if(!$this->inputType)
        {
            $this->inputType = $str;
        }
    }
}