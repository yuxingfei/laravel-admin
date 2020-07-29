<?php
/**
 * 编辑器server
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Services\EditorService;

class EditorController extends BaseController
{

    /**
     * @var EditorService 编辑器 服务
     */
    protected $editorService;

    /**
     * EditorController 构造函数.
     *
     * @param EditorService $editorService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(EditorService $editorService)
    {
        parent::__construct();

        $this->editorService = $editorService;
    }

    /**
     * 编辑器上传等url
     *
     * @return \Illuminate\Http\JsonResponse|string
     * Author: Stephen
     * Date: 2020/7/24 16:11:56
     */
    public function server()
    {
        return $this->editorService->server();
    }
}