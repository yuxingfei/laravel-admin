<?php
/**
 * 后台首页 控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Http\Controllers\Admin;

use App\Services\IndexService;

class IndexController extends BaseController
{
    /**
     * @var IndexService 首页服务
     */
    private $indexService;

    /**
     * IndexController 构造函数.
     *
     * @param IndexService $indexService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(IndexService $indexService)
    {
        parent::__construct();

        $this->indexService = $indexService;
    }

    /**
     * 首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:12:34
     */
    public function index()
    {
        $info = $this->indexService->getInfo();

        return view('admin.index.index',$info);
    }

}
