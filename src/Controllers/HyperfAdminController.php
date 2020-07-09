<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/9
 * Time: 17:38
 */

namespace Pl\HyperfAdmin\Controllers;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class HyperfAdminController
 * @package Pl\HyperfAdmin\Controllers
 */
abstract class HyperfAdminController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @Inject
     * @var RenderInterface
     */
    protected $render;
}