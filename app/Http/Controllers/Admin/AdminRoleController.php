<?php
/**
 * 后台角色控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Admin\AdminMenu;
use App\Model\Admin\AdminRole;
use App\Validate\Admin\AdminRoleValidate;
use Illuminate\Http\Request;

class AdminRoleController extends AdminBaseController
{

    /**
     * 首页
     *
     * @param Request $request
     * @param AdminRole $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:11
     */
    public function index(Request $request, AdminRole $model)
    {
        $param = $request->input();
        $data  = $model->addWhere($param)->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.admin_role.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param AdminRole $model
     * @param AdminRoleValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:11
     */
    public function add(Request $request, AdminRole $model, AdminRoleValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            $result = $model::create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            return $result ? success('添加成功', $url) : error();
        }

        return $this->admin_view('admin.admin_role.add');

    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param AdminRole $model
     * @param AdminRoleValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:12
     */
    public function edit($id, Request $request, AdminRole $model, AdminRoleValidate $validate)
    {
        $data = $model::find($id);
        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }

            $data->name        = $param['name'];
            $data->description = $param['description'];
            $data->status      = $param['status'];
            $result            = $data->save();

            return $result ? success() : error();
        }

        return $this->admin_view('admin.admin_role.add',[
            'data' => $data,
        ]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param AdminRole $model
     * Author: Stephen
     * Date: 2020/5/18 16:12
     */
    public function del(Request $request, AdminRole $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        if (count($model->noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($model->noDeletionId, $id)) {
                    return error('ID为' . implode(',', $model->noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $model->noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = $model->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 角色授权
     *
     * @param $id
     * @param Request $request
     * @param AdminRole $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:12
     */
    public function access($id, Request $request, AdminRole $model)
    {
        $data = $model->find($id);
        if ($request->isMethod('post')) {
            $param = $request->input();

            if (!isset($param['url'])) {
                return error('请至少选择一项权限');
            }
            if (!in_array(1, $param['url'])) {
                return error('首页权限必选');
            }

            asort( $param['url']);

            $data->url = $param['url'];

            if (false !== $data->save()) {
                return success();
            }
            return error();
        }

        $menu = AdminMenu::orderBy('sort_id', 'asc')->orderBy('id', 'asc')->get()->toArray();
        $menu = array_column($menu,NULL,'id');
        $html = $this->authorizeHtml($menu, $data->url);

        return $this->admin_view('admin.admin_role.access',[
            'data' => $data,
            'html' => $html,
        ]);
    }

    /**
     * 启用
     *
     * @param Request $request
     * @param AdminRole $model
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function enable(Request $request, AdminRole $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 1]);
        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * @param Request $request
     * @param AdminRole $model
     * Author: Stephen
     * Date: 2020/5/18 16:13
     */
    public function disable(Request $request, AdminRole $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 0]);
        return $result ? success('操作成功', URL_RELOAD) : error();
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
