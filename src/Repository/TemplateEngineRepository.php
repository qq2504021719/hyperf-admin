<?php

namespace Pl\HyperfAdmin\Repository;

use Hyperf\View\Engine\EngineInterface;
use duncan3dc\Laravel\BladeInstance;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;

/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/10
 * Time: 10:15
 */


class TemplateEngineRepository
{
    /**
     * 模板解析
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/10
     * Time: 10:46
     * @param $template
     * @param array $data
     * @return ResponseInterface
     */
    public function render($template,array $data = [])
    {
        // TODO: Implement render() method.
        $blade = new BladeInstance(__DIR__.'/../../storage/view/',BASE_PATH.'/runtime/view/');
        return $this->response()
            ->withAddedHeader('content-type', 'text/html')
            ->withBody(new SwooleStream($blade->render($template,$data)));
    }

    /**
     * 获取response响应体
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/10
     * Time: 10:45
     * @return ResponseInterface
     */
    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
}