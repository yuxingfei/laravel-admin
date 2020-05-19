<?php
/**
 * 后台菜单控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Admin\AdminMenu;
use App\Validate\Admin\AdminMenuValidate;
use Illuminate\Http\Request;


class AdminMenuController extends AdminBaseController
{
    /**
     * 首页
     *
     * @param Request $request
     * @param AdminMenu $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:08
     */
    public function index(Request $request, AdminMenu $model)
    {
        //查询所有菜单并以树的形式显示
        $result = $model->orderBy('sort_id','asc')->orderBy('id','asc')->get()->toArray();
        $result = array_column($result,NULL,'id');
        foreach ($result as $n => $r) {
            $result[$n]['level']          = $this->getLevel($r['id'], $result);
            $result[$n]['parent_id_node'] = $r['parent_id'] ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
            $result[$n]['str_manage']     = '<a href="' . url('admin/admin_menu/edit', ['id' => $r['id']]) . '" class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> ';
            $result[$n]['str_manage']     .= '<a class="btn btn-danger btn-xs AjaxButton" data-id="' . $r['id'] . '" data-url="del"  data-confirm-title="删除确认" data-confirm-content=\'您确定要删除ID为 <span class="text-red"> ' . $r['id'] . ' </span> 的数据吗\'  data-toggle="tooltip" title="删除"><i class="fa fa-trash"></i></a>';
            $result[$n]['is_show']        = (int)$r['is_show'] === 1 ? '显示' : '隐藏';
            $result[$n]['log_method']     = $r['log_method'];
        }

        $str = "<tr id='node-\$id' data-level='\$level' \$parent_id_node><td><input type='checkbox' onclick='checkThis(this)'
                     name='data-checkbox' data-id='\$id\' class='checkbox data-list-check' value='\$id' placeholder='选择/取消'>
                    </td><td>\$id</td><td>\$spacer\$name</td><td>\$url</td>
                    <td>\$parent_id</td><td><i class='fa \$icon'></i><span>(\$icon)</span></td>
                    <td>\$sort_id</td><td>\$is_show</td><td>\$log_method</td><td class='td-do'>\$str_manage</td></tr>";

        $this->initTree($result);
        $data = $this->getTree(0, $str);
        return $this->admin_view('admin.admin_menu.index',['data'  => $data]);
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param AdminMenu $model
     * @param AdminMenuValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:09
     */
    public function add(Request $request, AdminMenu $model, AdminMenuValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            $result = $model->create($param);

            //如果
            if (isset($param['is_more']) && $param['is_more'] == 1) {
                $name = $param['more_name'];
                $url  = explode('/', $param['url']);
                $str  = '/';
                $data = [
                    [
                        'parent_id' => $result->id,
                        'name'      => '添加' . $name,
                        'url'       => $url[0] . $str . $url[1] . $str . 'add',
                        'icon'      => 'fa-plus',
                        'is_show'   => 0,
                        'log_method'  => 'POST',
                    ],
                    [
                        'parent_id' => $result->id,
                        'name'      => '修改' . $name,
                        'url'       => $url[0] . $str . $url[1] . $str . 'edit',
                        'icon'      => 'fa-pencil',
                        'is_show'   => 0,
                        'log_method'  => 'POST',
                    ],
                    [
                        'parent_id' => $result->id,
                        'name'      => '删除' . $name,
                        'url'       => $url[0] . $str . $url[1] . $str . 'del',
                        'icon'      => 'fa-trash',
                        'is_show'   => 0,
                        'log_method'  =>'POST',
                    ]
                ];

                $model->insert($data);

            }
            unset($url);
            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            return $result ? success('添加成功', $url) : error();
        }

        $parent_id = $request->input('parent_id') ?? 0;
        $parents   = $this->menu($parent_id);

        return $this->admin_view('admin.admin_menu.add',[
            'parents'    => $parents,
            'log_method' => $model->logMethod
        ]);

    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param AdminMenu $model
     * @param AdminMenuValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:09
     */
    public function edit($id, Request $request, AdminMenu $model, AdminMenuValidate $validate)
    {

        $data = $model->find($id);
        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }

            $data->parent_id = $param['parent_id'];
            $data->name = $param['name'];
            $data->url = $param['url'];
            $data->icon = $param['icon'];
            $data->sort_id = $param['sort_id'];
            $data->is_show = $param['is_show'];
            $data->log_method = $param['log_method'];

            $result = $data->save();
            return $result ? success() : error();
        }

        $parent_id = $data->parent_id;
        $parents   = $this->menu($parent_id);

        return $this->admin_view('admin.admin_menu.add',[
            'data'       => $data,
            'parents'    => $parents,
            'log_method' => $model->logMethod,
        ]);
    }

    /**
     * 删除
     *
     * @param Request $request
     * @param AdminMenu $model
     * Author: Stephen
     * Date: 2020/5/18 16:10
     */
    public function del(Request $request, AdminMenu $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        //判断是否有子菜单
        $have_son = $model->whereIn('parent_id', $id)->first();
        if ($have_son) {
            return error('有子菜单不可删除！');
        }

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
     * 菜单选择 select树形选择
     *
     * @param int $selected
     * @param int $current_id
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:10
     */
    protected function menu($selected = 1, $current_id = 0)
    {
        $result = AdminMenu::where('id', '<>', $current_id)
            ->orderBy('sort_id', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id','parent_id','name','sort_id'])
            ->toArray();

        $result = array_column($result,NULL,'id');

        foreach ($result as $r) {
            $r['selected'] = (int)$r['id'] === (int)$selected ? 'selected' : '';
        }

        $str = "<option value='\$id' \$selected >\$spacer \$name</option>";
        $this->initTree($result);

        return $this->getTree(0, $str, $selected);
    }

}