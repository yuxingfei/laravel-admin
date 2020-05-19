<?php
/**
 * admin模块基础控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Admin\AdminAuth;
use App\Http\Traits\Admin\AdminTree;
use App\Http\Traits\Admin\PhpOffice;
use App\Model\Admin\AdminMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AdminBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use AdminAuth,AdminTree,PhpOffice;

    /**
     * @var array 分页设置
     */
    protected $perPageConfig = [10,20,30,50,100];

    /**
     * 当前url
     * @var string
     */
    protected $url;

    /**
     * 当前用户ID
     * @var int
     */
    protected $uid = 0;

    /**
     * 当前用户
     * @var AdminUser
     */
    protected $user;

    /**
     * 后台变量
     * @var array
     */
    protected $admin;

    /**
     * 无需验证权限的url
     * @var array
     */
    protected $authExcept = [];

    public function __construct(Request $request)
    {
        //获取当前访问url
        $this->url = $this->getRouteUrl($request->path());

        //验证权限
        if (!in_array($this->url, $this->authExcept, true)) {
            $isLogin = $this->isLogin();
            if (!$isLogin) {
                error('未登录', 'admin/auth/login');
            } else if ($this->user->id !== 1 && !$this->authCheck($this->user)) {
                error('无权限', $request->isMethod('get') ? null : URL_CURRENT);
            }
        }

        if ((int)$request->input('check_auth') === 1) {
            success();
        }

        //记录日志
        $menu = AdminMenu::firstWhere(['url' => $this->url]);
        if ($menu) {
            $this->admin['title'] = $menu->name;
            if ($menu->log_method === $request->method()) {
                $this->createAdminLog($this->user, $menu);
            }
        }

        $this->admin['per_page'] = request()->cookie('admin_per_page') ?? 10;
        $this->admin['per_page_config'] = $this->perPageConfig;
        $this->admin['per_page'] = $this->admin['per_page'] < 100 ? $this->admin['per_page'] : 100;

    }

    //空方法
    public function _empty()
    {
        $this->admin['title'] = '404';
        return view('admin.template.404');
    }

    /**
     * 设置前台显示的后台信息
     *
     * Author: Stephen
     * Date: 2020/5/18 16:06
     */
    protected function setAdminInfo(): void
    {
        $admin_config = config('Admin.admin.base');

        $this->admin['name']       = $admin_config['name'] ?? '';
        $this->admin['author']     = $admin_config['author'] ?? '';
        $this->admin['version']    = $admin_config['version'] ?? '';
        $this->admin['short_name'] = $admin_config['short_name'] ?? '';
    }


    /**
     * 重写view
     *
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/9 17:19
     */
    protected function admin_view($view = null, $data = [], $mergeData = [])
    {
        $factory = app(ViewFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        $this->admin['pjax'] = request()->pjax();
        $this->admin['user'] = $this->user;
        $this->setAdminInfo();
        if ('admin/auth/login' !== $this->url && !$this->admin['pjax']) {
            $this->admin['menu'] = $this->getLeftMenu($this->user);
        }

        $data = array_merge([
            'debug'         => env('APP_DEBUG') ? 'true' : 'false',
            'cookie_prefix' => '',
            'admin'         => $this->admin,
        ],$data);

        return $factory->make($view, $data, $mergeData);
    }

    /**
     * 获取访问路径模块/控制器/方法
     *
     * @param Request $request
     * @return string
     * Author: Stephen
     * Date: 2020/5/14 17:32
     */
    protected function getRouteUrl($url){
        $urlArr = explode('/',$url);
        if('admin' == $urlArr[0]){
            if(count($urlArr) <= 3){
                return $url;
            }else{
                return $urlArr[0]. '/' . $urlArr[1] . '/'.$urlArr[2];
            }
        }else{
            return $url;
        }
    }

}