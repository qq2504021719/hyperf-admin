<?php
namespace Pl\HyperfAdmin\Middleware;

use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Pl\HyperfAdmin\Lib\Functions;
use Pl\HyperfAdmin\Repository\AuthRepository;
use Pl\HyperfAdmin\Repository\StateRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/8/5
 * Time: 14:01
 */

class HyperfAuthMiddleware implements MiddlewareInterface
{
    use Functions;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * session
     * @var SessionInterface
     */
    protected $session;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request,SessionInterface $session)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 获取用户信息
        $user = AuthRepository::user($this->session);
        if(!$user)
        {
            return $this->response->redirect($this->getUrl(StateRepository::URL_LOGIN));
        }
        // 继续执行
        return $handler->handle($request);
    }
}