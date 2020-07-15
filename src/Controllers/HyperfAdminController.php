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
use Pl\HyperfAdmin\Repository\TemplateEngineRepository;
use Psr\Container\ContainerInterface;

/**
 * Class HyperfAdminController
 * @package Pl\HyperfAdmin\Controllers
 */
abstract class HyperfAdminController
{
    protected $title = '';

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
     * 自定义模板解析
     * @Inject
     * @var TemplateEngineRepository
     */
    protected $render;
}