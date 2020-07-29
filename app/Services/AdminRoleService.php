<?php
/**
 * 用户角色 服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Repositories\Admin\Contracts\AdminRoleInterface;
use App\Traits\Admin\AdminTree;
use App\Validate\Admin\AdminRoleValidate;
use Illuminate\Http\Request;

class AdminRoleService extends AdminBaseService
{
    use AdminTree;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var AdminRoleValidate 用户角色验证器
     */
    protected $validate;

    /**
     * @var AdminRoleInterface 用户角色 仓库
     */
    protected $adminRole;

    /**
     * @var AdminMenuInterface 后台菜单 仓库
     */
    protected $adminMenu;

    /**
     * AdminRoleService 构造函数.
     *
     * @param Request $request
     * @param AdminRoleValidate $validate
     * @param AdminRoleInterface $adminRole
     * @param AdminMenuInterface $adminMenu
     */
    public function __construct(
        Request $request ,
        AdminRoleValidate $validate,
        AdminRoleInterface $adminRole,
        AdminMenuInterface $adminMenu
    )
    {
        $this->request   = $request;
        $this->validate  = $validate;
        $this->adminRole = $adminRole;
        $this->adminMenu = $adminMenu;
    }

    /**
     * 用户角色首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:08:48
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->adminRole->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 创建用户角色
     *
     * Author: Stephen
     * Date: 2020/7/27 17:09:26
     */
    public function create()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->adminRole->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 编辑用户角色
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 17:09:56
     */
    public function edit($id)
    {
        return $this->adminRole->findById($id);
    }

    /**
     * 更新用户角色
     *
     * Author: Stephen
     * Date: 2020/7/27 17:12:05
     */
    public function update()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->adminRole->update($param);

        return $result ? success() : error();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/27 17:12:38
     */
    public function enable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->adminRole->enable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/7/27 17:12:59
     */
    public function disable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->adminRole->disable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 删除用户角色
     *
     * Author: Stephen
     * Date: 2020/7/27 17:13:17
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->adminRole->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 授权界面
     *
     * @param $id
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:14:10
     */
    public function access($id)
    {
        $data = $this->adminRole->findById($id);

        $menu = $this->adminMenu->allMenu();

        $html = $this->authorizeHtml($menu, $data->url);

        return [
            'data' => $data,
            'html' => $html,
        ];
    }

    /**
     * 授权操作
     *
     * Author: Stephen
     * Date: 2020/7/27 17:14:30
     */
    public function accessOperate()
    {
        $param = $this->request->input();

        if (!isset($param['url'])) {
            return error('请至少选择一项权限');
        }

        if (!in_array(1, $param['url'])) {
            return error('首页权限必选');
        }

        if (false !== $this->adminRole->storeAccess($param)) {
            return success();
        }

        return error();
    }

    /**
     * 生成授权html
     *
     * @param $menu
     * @param array $auth_menus
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:15
     */
    protected function authorizeHtml($menu, $auth_menus = [])
    {
        foreach ($menu as $n => $t) {
            $menu[$n]['checked'] = in_array($t['id'], $auth_menus) ? ' checked' : '';
            $menu[$n]['level']   = $this->getLevel($t['id'], $menu);
            $menu[$n]['width']   = 100 - $menu[$n]['level'];
        }

        $this->initTree($menu);

        $this->text = [
            'other' => "<label class='checkbox'  >
                        <input \$checked  name='url[]' value='\$id' level='\$level'
                        onclick='javascript:checkNode(this);' type='checkbox'>
                       \$name
                   </label>",
            '0'     => [
                '0' => "<dl class='checkMod'>
                    <dt class='hd'>
                        <label class='checkbox'>
                            <input \$checked name='url[]' value='\$id' level='\$level'
                             onclick='javascript:checkNode(this);'
                             type='checkbox'>
                            \$name
                        </label>
                    </dt>
                    <dd class='bd'>",
                '1' => '</dd></dl>',
            ],
            '1'     => [
                '0' => "
                        <div class='menu_parent'>
                            <label class='checkbox'>
                                <input \$checked  name='url[]' value='\$id' level='\$level'
                                onclick='javascript:checkNode(this);' type='checkbox'>
                               \$name
                            </label>
                        </div>
                        <div class='rule_check' style='width: \$width%;'>",
                '1' => "</div><span class='child_row'></span>",
            ]
        ];

        return $this->getAuthTreeAccess(0);
    }

}