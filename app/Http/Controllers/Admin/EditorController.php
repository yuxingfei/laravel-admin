<?php
/**
 * 编辑器server
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libs\UEditor;

class EditorController extends AdminBaseController
{
    /**
     * @var array 排除认证url
     */
    protected $authExcept = [
        'admin/editor/server',
    ];

    /**
     * 编辑器上传等url
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * Author: Stephen
     * Date: 2020/5/18 16:21
     */
    public function server(Request $request)
    {
        $param = $request->input();

        $config = config('Admin.ueditor');
        $action  = $param['action'];
        $editor = new UEditor($config);

        return $editor->server($action);
    }
}