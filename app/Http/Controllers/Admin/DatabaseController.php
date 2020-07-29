<?php
/**
 * 数据库维护 控制器
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/24
 * Time: 10:30
 */

namespace App\Http\Controllers\Admin;

use App\Services\DatabaseService;
use Illuminate\Http\Request;

class DatabaseController extends BaseController
{
    /**
     * 数据库服务
     *
     * @var DatabaseService
     */
    protected $databaseService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * DatabaseController 构造函数.
     *
     * @param DatabaseService $databaseService
     * @param Request $request
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(DatabaseService $databaseService,Request $request)
    {
        parent::__construct();

        $this->databaseService = $databaseService;

        $this->request         = $request;
    }

    /**
     * 显示数据表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:10:01
     */
    public function table()
    {
        $data = $this->databaseService->getTableStatus();

        return view('admin.database.table',[
            'data'  => $data,
            'total' => count($data),
        ]);
    }

    /**
     * 查看数据表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * Author: Stephen
     * Date: 2020/7/24 16:10:16
     */
    public function view()
    {
        $name = $this->request->query('name');

        if (!$name) {
            return error('请指定要查看的表');
        }

        $data = $this->databaseService->getFullColumnsFromTable($name);

        return view('admin.database.view',[
            'data'  => $data,
        ]);
    }

    /**
     * 优化表
     *
     * Author: Stephen
     * Date: 2020/7/24 16:10:44
     */
    public function optimize()
    {
        $name = $this->request->input('name');

        if (!$name) {
            return error('请指定要优化的表');
        }

        $name   = is_array($name) ? implode('`,`', $name) : $name;

        return $this->databaseService->optimizeTable($name);
    }

    /**
     * 修复表
     *
     * Author: Stephen
     * Date: 2020/7/24 16:11:04
     */
    public function repair()
    {
        $name = $this->request->input('name');

        if (!$name) {
            return error('请指定要修复的表');
        }

        $name   = is_array($name) ? implode('`,`', $name) : $name;

        return $this->databaseService->repairTable($name);
    }

}