<?php
/**
 * 设置中心 Controller
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 16:23
 */

namespace App\Http\Controllers\Admin;

use App\Services\SettingService;

class SettingController extends BaseController
{
    /**
     * @var SettingService 设置服务
     */
    protected $settingService;

    /**
     * SettingController 构造函数.
     *
     * @param SettingService $settingService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(SettingService $settingService)
    {
        parent::__construct();

        $this->settingService = $settingService;
    }

    /**
     * 设置列表页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:14
     */
    public function index()
    {
        $data = $this->settingService->getPageData();

        return view('admin.setting.index',$data);
    }

    /**
     * 所有配置
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:27
     */
    public function all()
    {
        $data = $this->settingService->getPageDataForAll();

        return view('admin.setting.all',$data);
    }

    /**
     * 单个配置信息
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:45
     */
    public function info($id)
    {
        return $this->show($id);
    }

    /**
     * 展示单个配置信息
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:13:58
     */
    protected function show($id)
    {
        $data = $this->settingService->show($id);

        return view('admin.setting.show',['data_config' => $data]);
    }

    /**
     * 更新配置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:14:16
     */
    public function update()
    {
        return $this->settingService->update();
    }

    /**
     * 设置
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:14:25
     */
    public function admin()
    {
        return $this->show(1);
    }

    /**
     * 添加设置界面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:15:10
     */
    public function add()
    {
        $settingGroupList = $this->settingService->getSettingGroupList();

        return view('admin.setting.add',['setting_group_list' => $settingGroupList]);
    }

    /**
     * 创建设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:20
     */
    public function create()
    {
        return $this->settingService->create();
    }

    /**
     * 编辑设置界面
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Author: Stephen
     * Date: 2020/7/24 16:15:29
     */
    public function edit($id)
    {
        $data = $this->settingService->findById($id);

        return view('admin.setting.edit',[
            'data'               => $data,
            'setting_group_list' => $this->settingService->getSettingGroupList(),
        ]);
    }

    /**
     * 更新设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:15:48
     */
    public function doUpdate()
    {
        return $this->settingService->doUpdate();
    }

    /**
     * 删除设置
     *
     * Author: Stephen
     * Date: 2020/7/24 16:16:12
     */
    public function del()
    {
        return $this->settingService->del();
    }

}