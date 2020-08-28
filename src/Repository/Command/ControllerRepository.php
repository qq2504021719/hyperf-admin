<?php
namespace Pl\HyperfAdmin\Repository\Command;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/28
 * Time: 10:00
 */

class ControllerRepository
{
    protected $path = '';                           // 后台代码存放目录
    protected $namespace;                           // 类命名空间
    protected $name;                                // 控制文件名称
    protected $controllerName;                      // 控制器名称
    protected $modelNamespace;                      // 模型命名空间
    protected $modelName;                           // 模型名称
    protected $modelPath;                           // 模型路径
    protected $modelNameExt;                        // 模型名称加后缀
    protected $route;                               // 控制器路由声明

    protected $param1;                              // 参数1
    protected $param2;                              // 参数2

    protected $templatePath;                        // 模板路径

    /**
     * 是否结束
     * true 是
     * false 否
     * @var bool
     */
    protected $end = false;

    /**
     * 调试
     * true 开启
     * false 关闭
     * @var bool
     */
    protected $debug = false;


    protected $that;


    public function __construct($param1,$param2,$that)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->that = $that;
        $this->path = BASE_PATH.'/app/'.config('hyperf-admin.code_path').'/Controller';
        $this->modelPath = BASE_PATH;
        $this->namespace = config('hyperf-admin.code_path').'\\Controller';
        $this->templatePath = __DIR__ . '/../../../publish/TemplateController.tem';
    }

    /**
     * 入口
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/28
     * Time: 10:11
     */
    public function init()
    {
        // 输入参数初始化
        $this->paramsInit();
        // 参数替换
        $this->strReplace();
    }


    /**
     * 输入参数初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 16:28
     */
    private function paramsInit()
    {
        $that = $this->that;
        // 检查控制器是否已存在
        $this->isController();
        // 检查model是否存在
        $this->isModel();

        if($this->debug)
        {
            $that->echo('路径:'.$this->path);
            $that->echo('名称:'.$this->name);
            $that->echo('命名空间:'.$this->namespace);
            $that->echo('控制器名称:'.$this->controllerName);
            $that->echo('模型路径:'.$this->modelPath);
            $that->echo('模型名称:'.$this->modelName);
            $that->echo('命名空间:'.$this->modelNamespace);
            $that->echo('控制器名称加后缀:'.$this->modelNameExt);
        }
        $that->echo('路由:'.$this->route);
    }

    /**
     *
     * 检查控制器
     * 存在报错
     * 检查对应目录是否存在
     * 不存在创建
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 17:37
     */
    private function isController()
    {
        $name = $this->param1;
        $that = $this->that;

        $arr = explode('/',$name);

        $len = count($arr);

        if($len > 1)
        {
            for($i = 0; $i<($len-1);$i++)
            {
                // 文件路径
                $this->path .= '/'.$arr[$i];
                // 命名空间
                $this->namespace .= '\\'.$arr[$i];
            }
        }
        
        // 路由声明
        if($len > 1)
        {
            for($i = 0; $i<$len;$i++)
            {
                // 路由
                $this->route .= '/'.$arr[$i];
            }
        }
        else
        {
            $this->route = '/'.$arr[$len-1];
        }
        

        // 控制器名称
        $this->name = $arr[$len-1];
        // 控制器名称
        $this->controllerName = $this->name.'Controller.php';

        // 目录不存在创建目录
        if(!is_dir($this->path))
        {
            mkdir($this->path,0777,true);
            if(is_dir($this->path))$that->echo('目录创建成功');
        }

        // 文件存在返回停止执行
        if(is_file($this->path.'/'.$this->controllerName))
        {
            $that->bugEcho('控制器已存在,请确认名称是否正确');
            $this->end = true;
        }
    }

    /**
     * 检查模型是否存在
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/28
     * Time: 9:56
     */
    private function isModel()
    {
        $modelPath = $this->param2;
        $that = $this->that;

        if($this->end === false)
        {
            $arr = explode('/',$modelPath);

            $len = count($arr);

            if($len > 1)
            {
                for($i = 0; $i<($len-1);$i++)
                {
                    // 文件路径
                    $this->modelPath .= '/'.$arr[$i];
                    // 命名空间
                    $this->modelNamespace .= $this->modelNamespace?'\\'.$arr[$i]:$arr[$i];
                }
            }
            // 控制器名称
            $this->modelName = $arr[$len-1];
            // 控制器名称
            $this->modelNameExt = $this->modelName.'.php';

            // 文件不存在停止执行
            if(!is_file($this->modelPath.'/'.$this->modelNameExt))
            {
                $that->bugEcho($modelPath.'模型不存在');
                $this->end = true;
            }

        }
    }

    /**
     * 参数替换-生成
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/28
     * Time: 10:13
     */
    private function strReplace()
    {
        $that = $this->that;
        $prefix = '/'.config('hyperf-admin.route.prefix');
        $route = $this->route;

        $str = file_get_contents($this->templatePath);
        $str = str_replace('{namespace}',$this->namespace,$str);
        $str = str_replace('{modelNamespace}',$this->modelNamespace,$str);
        $str = str_replace('{model}',$this->modelName,$str);
        $str = str_replace('{name}',$this->name,$str);
        $str = str_replace('{prefix}',$prefix,$str);
        $str = str_replace('{route}',$route,$str);

        // 生成文件
        $path = $this->path.'/'.$this->controllerName;
        file_put_contents($path,$str);
        if(is_file($path))
        {
            $that->echo('控制器生成成功');
        }
    }

}