<?php
/**
 * UEditor插件 服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 17:00
 */

namespace App\Services;

use App\Libs\UEditor;
use Illuminate\Http\Request;

class EditorService
{
    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * EditorService 构造函数.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request   = $request;
    }

    /**
     * ueditor的服务处理
     *
     * @return \Illuminate\Http\JsonResponse|string
     * Author: Stephen
     * Date: 2020/7/28 10:23:26
     */
    public function server()
    {
        $param   = $this->request->input();

        $config  = config('admin.ueditor');
        $action  = $param['action'];
        $editor  = new UEditor($config);

        return $editor->server($action);
    }

}