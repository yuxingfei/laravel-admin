<?php
/**
 * 用户管理 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */

namespace App\Services;

use App\Repositories\Admin\Contracts\AdminMenuInterface;
use App\Traits\Admin\AdminTree;
use App\Validate\Admin\AdminMenuValidate;
use Illuminate\Http\Request;

class AdminMenuService extends AdminBaseService
{
    use AdminTree;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var AdminMenuValidate 后台菜单验证器
     */
    protected $validate;

    /**
     * @var AdminMenuInterface 菜单仓库
     */
    protected $adminMenu;

    /**
     * AdminMenuService 构造函数.
     *
     * @param Request $request
     * @param AdminMenuValidate $validate
     * @param AdminMenuInterface $adminMenu
     */
    public function __construct(
        Request $request ,
        AdminMenuValidate $validate ,
        AdminMenuInterface $adminMenu
    )
    {
        $this->request   = $request;
        $this->validate  = $validate;
        $this->adminMenu = $adminMenu;
    }

    /**
     * 生成菜单树
     *
     * @return string
     * Author: Stephen
     * Date: 2020/7/27 17:04:31
     */
    public function adminMenuTree()
    {
        //查询所有菜单并以树的形式显示
        $result = $this->adminMenu->allMenu();

        foreach ($result as $n => $r) {
            $result[$n]['level']          = $this->getLevel($r['id'], $result);
            $result[$n]['parent_id_node'] = $r['parent_id'] ? ' class="child-of-node-' . $r['parent_id'] . '"' : '';
            $result[$n]['str_manage']     = '<a href="' . route('admin.admin_menu.edit', ['id' => $r['id']]) . '" class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip"><i class="fa fa-pencil"></i></a> ';
            $result[$n]['str_manage']     .= '<a class="btn btn-danger btn-xs AjaxButton" data-id="' . $r['id'] . '" data-url="del"  data-confirm-title="删除确认" data-confirm-content=\'您确定要删除ID为 <span class="text-red"> ' . $r['id'] . ' </span> 的数据吗\'  data-toggle="tooltip" title="删除"><i class="fa fa-trash"></i></a>';
            $result[$n]['is_show']        = (int)$r['is_show'] === 1 ? '显示' : '隐藏';
            $result[$n]['log_method']     = $r['log_method'];
        }

        $str = "<tr id='node-\$id' data-level='\$level' \$parent_id_node><td><input type='checkbox' onclick='checkThis(this)'
                     name='data-checkbox' data-id='\$id\' class='checkbox data-list-check' value='\$id' placeholder='选择/取消'>
                    </td><td>\$id</td><td>\$spacer\$name</td><td>\$url</td><td>\$route_name</td>
                    <td>\$parent_id</td><td><i class='fa \$icon'></i><span>(\$icon)</span></td>
                    <td>\$sort_id</td><td>\$is_show</td><td>\$log_method</td><td class='td-do'>\$str_manage</td></tr>";

        $this->initTree($result);

        return $this->getTree(0, $str);
    }

    /**
     * 添加菜单
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:05:03
     */
    public function add()
    {
        $parent_id = $this->request->input('parent_id') ?? 0;
        $parents   = $this->menu($parent_id);

        return [
            'parents'    => $parents,
            'log_method' => $this->adminMenu->getLogMethod()
        ];
    }

    /**
     * 生成菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:05:43
     */
    public function create()
    {
        $param           = $this->request->input();
        $validate_result = $this->validate->scene('add')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        if(isset($param['route_name'])){
            $param['route_name'] = trim($param['route_name']);
        }

        $result = $this->adminMenu->create($param);

        //如果
        if (isset($param['is_more']) && $param['is_more'] == 1) {
            $name      = $param['more_name'];
            $routeName = $param['route_name'];
            $url  = explode('/', $param['url']);
            $str  = '/';
            $data = [
                [
                    'parent_id'    => $result->id,
                    'name'         => '添加' . $name,
                    'url'          => $url[0] . $str . $url[1] . $str . 'add',
                    'route_name'   => $routeName,
                    'icon'         => 'fa-plus',
                    'is_show'      => 0,
                    'log_method'   => 'POST',
                ],
                [
                    'parent_id'    => $result->id,
                    'name'         => '修改' . $name,
                    'url'          => $url[0] . $str . $url[1] . $str . 'edit',
                    'route_name'   => $routeName,
                    'icon'         => 'fa-pencil',
                    'is_show'      => 0,
                    'log_method'   => 'POST',
                ],
                [
                    'parent_id'    => $result->id,
                    'name'         => '删除' . $name,
                    'url'          => $url[0] . $str . $url[1] . $str . 'del',
                    'route_name'   => $routeName,
                    'icon'         => 'fa-trash',
                    'is_show'      => 0,
                    'log_method'   =>'POST',
                ]
            ];

            $this->adminMenu->insert($data);

        }
        unset($url);
        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 编辑菜单
     *
     * @param $id
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:06:00
     */
    public function edit($id)
    {
        $data      = $this->adminMenu->find($id);

        $parent_id = $data->parent_id;

        $parents   = $this->menu($parent_id);

        return [
            'data'       => $data,
            'parents'    => $parents,
            'log_method' => $this->adminMenu->getLogMethod(),
        ];
    }

    /**
     * 更新菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:06:28
     */
    public function update()
    {
        $param           = $this->request->input();
        $validate_result = $this->validate->scene('edit')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->adminMenu->update($param);

        return $result ? success() : error();
    }

    /**
     * 删除菜单
     *
     * Author: Stephen
     * Date: 2020/7/27 17:06:46
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->adminMenu->destroy($id);

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
        $result = $this->adminMenu->menu($current_id);
        $result = array_column($result,NULL,'id');

        foreach ($result as $r) {
            $r['selected'] = (int)$r['id'] === (int)$selected ? 'selected' : '';
        }

        $str = "<option value='\$id' \$selected >\$spacer \$name</option>";
        $this->initTree($result);

        return $this->getTree(0, $str, $selected);
    }

}