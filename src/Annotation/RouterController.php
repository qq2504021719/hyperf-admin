<?php
declare(strict_types=1);


/**
 * 注释路由重写
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/18
 * Time: 14:50
 */

namespace Pl\HyperfAdmin\Annotation;

use App\Controller\AbstractController;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
class RouterController extends AbstractController
{
    /**
     * @var null|string
     */
    public $prefix = '';

    /**
     * @var string
     */
    public $server = 'http';
    public function __construct($value = null)
    {
        var_dump([$value,$this->prefix]);
        $this->prefix = '/admin/'.$value['prefix'];
        $value['prefix'] = '/admin/'.$value['prefix'];
//        parent::__construct($value);
        var_dump([$value,$this->prefix]);


    }
}