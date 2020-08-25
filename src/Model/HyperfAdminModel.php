<?php
namespace Pl\HyperfAdmin\Model;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/16
 * Time: 10:26
 */

use App\Model\Model;
use Hyperf\DbConnection\Model\Model as BaseModel;
use Hyperf\ModelCache\Cacheable;
use Hyperf\ModelCache\CacheableInterface;

abstract class HyperfAdminModel extends Model implements CacheableInterface
{
    use Cacheable;
}