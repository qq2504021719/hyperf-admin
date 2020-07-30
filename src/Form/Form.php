<?php
namespace Pl\HyperfAdmin\Form;
use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\HyperfAdmin;
use Pl\HyperfAdmin\Model\HyperfAdminModel;

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


    public function html()
    {
        
    }
}