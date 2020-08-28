<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Pl\HyperfAdmin\Repository\Command\ControllerRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * @Command
 */
class HyperfAdminCommand extends HyperfCommand
{


    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('hyperf-admin:command');
    }

    /**
     * 帮助方法
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 18:02
     */
    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf-admin 快速创建控制');
        $this->addUsage('Base/Member App/Models/Users');
    }

    /**
     * 参数简介
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 18:03
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name',InputArgument::REQUIRED,'控制命名空间及名称'],
            ['modelPath',InputArgument::REQUIRED,'调用模型命名空间及名称']
        ];
    }



    /**
     * 命令入口
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 15:48
     */
    public function handle()
    {
        $name = $this->input->getArgument('name') ?? '';
        $modelPath = $this->input->getArgument('modelPath') ??'';
        $controller = new ControllerRepository($name,$modelPath,$this);
        $controller->init();
    }




    /**
     * 调试输出
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 16:28
     * @param $str
     */
    public function echo($str)
    {
        $this->line($str, 'info');
    }

    /**
     * 错误输出
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/8/27
     * Time: 16:28
     * @param $str
     */
    public function bugEcho($str)
    {
        $this->line("\033[31m$str\033[0m", 'info');
    }


}
