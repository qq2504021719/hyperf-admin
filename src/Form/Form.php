<?php
namespace Pl\HyperfAdmin\Form;

use App\Model\Model;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Contract\RequestInterface;
use parallel\Sync\Error;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Model\HyperfAdminModel;
use Pl\HyperfAdmin\Repository\Redis\ExceptionDataRedis;
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
     * 编辑edit 编辑保存edit_save 添加add 添加保存add_save
     * @var string
     */
    public $met = '';

    /**
     * formHtml
     * @var string
     */
    private $formHtml = '';

    /**
     * 主键id
     * @var string
     */
    private $id = '';

    /**
     * 是否开启悲观锁更改数据
     * @var
     */
    public  $isLockForUpdate;

    /**
     * 保存前回调
     * @var
     */
    public $saveFrontCallback = '';

    /**
     * 验证是否通过
     * 验证通过
     * 验证未通过
     * @var bool
     */
    public $isVerify = false;

    public function __construct(Model $model)
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
        $field->met = $this->met;
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
        $id = $this->request->input('id','');

        // 编辑的状态查数据库数据
        if($this->met === StateRepository::FORM_EDIT)
        {
            $data = $this->model->where('id',$id)->first();
        }
        // 编辑保存
        else if($this->met === StateRepository::FORM_EDIT_SAVE)
        {
            $data = $this->model->where('id',$id)->first();
        }
        else if($this->met === StateRepository::FORM_ADD_SAVE)
        {
            $data = $this->request->all();
        }
        // 添加的状态从参数获取

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
            'themeColor' => $this->themeColor,
            'id' => $this->id,
            'action' => $this->getActivity()
        ]);
        $this->html .= $html;


    }

    /**
     * form-url
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 10:58
     */
    private function getActivity()
    {
        $url = '';
        if($this->met == StateRepository::FORM_ADD)
        {
            $url = $this->getUrl($this->route.'/'.StateRepository::URL_ADD_SAVE.'?id='.$this->id);
        }
        else
        {
            $url = $this->getUrl($this->route.'/'.StateRepository::URL_EDIT_SAVE.'?id='.$this->id);
        }
        return $url;
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

        // 提示
        $this->html .= $this->getToastr();
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
        $this->id = $this->request->input('id');
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

        $params = $this->layoutScript([]);
        return ViewRepository::viewInitLine($this->request,$this->html,$params,$this->session);
    }


    /**
     * 验证
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/24
     * Time: 17:50
     */
    public function verify()
    {

        $this->isVerify = true;
        $rules = [];
        $messages = [];
        // 验证规则拼接
        foreach ($this->forms as $k=>$v)
        {
            $name = $v->name;
            $rule = $v->rule;
            $message = $v->message;
            if($rule)$rules[$k] = $rule;
            if(is_array($message) && count($message) > 0){
                foreach ($message as $k=>$v1)
                {
                    $messages[$name.'.'.$k] = $v1;
                }
            }
        }

        if(count($rules))
        {
            // 验证
            $validator = $this->validationFactory->make(
                $this->request->all(),
                $rules,
                $messages
            );

            if ($validator->fails()){
                $this->isVerify = false;
                $arr = $validator->errors()->getMessages();
                foreach ($arr as $k=>$v)
                {
                    $this->forms[$k]->errorStr = implode(',',$v);
                }
            }
        }
    }


    /**
     * 编辑提交修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 10:04
     */
    public function editSave()
    {
        try
        {
            $params = $this->request->all();
            $updates = [];
            // 保存前回调
            $params = $this->saveFrontCallback($params);

            foreach ($this->fileds as $v)
            {
                $updates[$v] = $this->arrIsKey($params,$v);
            }
            Db::beginTransaction();
            $query = $this->model;

            if($this->isLockForUpdate)
            {
                $query->lockForUpdate();
            }
            $query->where('id',$this->arrIsKey($params,'id'))->update($updates);
            Db::commit();
        }catch (\Exception $exception)
        {
            $redis = new ExceptionDataRedis();
            $redis->set($exception);
        }
    }

    /**
     * 保存前回调
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 14:13
     * @param $params
     * @return mixed
     */
    private function saveFrontCallback($params)
    {
        $saveFrontCallback = $this->saveFrontCallback;
        if($saveFrontCallback)
        {
            $params = $saveFrontCallback($params);
        }
        return $params;
    }

    /**
     * 添加提交修改
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/5
     * Time: 10:04
     */
    public function addSave()
    {
        try
        {
            $params = $this->request->all();
            $inserts = [];

            // 保存前回调
            $params = $this->saveFrontCallback($params);


            Db::beginTransaction();
            $model = $this->modelM;
            foreach ($this->fileds as $v)
            {
                $model->$v = $this->arrIsKey($params,$v);
            }
            $model->save();
            Db::commit();
        }catch (\Exception $exception)
        {
            $redis = new ExceptionDataRedis();
            $redis->set($exception);
        }
    }
}