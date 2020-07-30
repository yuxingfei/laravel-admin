<?php
/**
 * 后台菜单 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Admin\AdminMenu;
use App\Repositories\Admin\Contracts\AdminMenuInterface;

class AdminMenuRepository implements AdminMenuInterface
{
    /**
     * 通过id查找
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:25:27
     */
    public function find($id)
    {
        return AdminMenu::find($id);
    }

    /**
     * 通过url查找数据
     *
     * @param $url
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:25:33
     */
    public function findBy($url)
    {
        return AdminMenu::firstWhere(['url' => $url]);
    }

    public function findByRouteName($routeName)
    {
        return AdminMenu::firstWhere(['route_name' => $routeName]);
    }

    /**
     * 查询所有菜单
     *
     * @return array|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:25:56
     */
    public function allMenu()
    {
        $result = AdminMenu::orderBy('sort_id','asc')->orderBy('id','asc')->get()->toArray();

        return array_column($result,NULL,'id');
    }

    /**
     * 除去当前id之外的所有菜单id
     *
     * @param int $current_id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:26:09
     */
    public function menu($current_id = 0)
    {
        return AdminMenu::where('id', '<>', $current_id)
            ->orderBy('sort_id', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id','parent_id','name','sort_id'])
            ->toArray();
    }

    /**
     * 获取模型中logMethod属性
     *
     * @return array|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:26:25
     */
    public function getLogMethod()
    {
        return (new AdminMenu())->logMethod;
    }

    /**
     * 创建菜单
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:26:44
     */
    public function create($param)
    {
        return AdminMenu::create($param);
    }

    /**
     * 插入多条菜单数据
     *
     * @param $data
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:26:56
     */
    public function insert($data)
    {
        return AdminMenu::insert($data);
    }

    /**
     * 修改菜单数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:27:06
     */
    public function update($param)
    {
        $data = $this->find($param['id']);

        $data->parent_id    = $param['parent_id'];
        $data->name         = $param['name'];
        $data->url          = $param['url'];
        $data->route_name   = trim($param['route_name']);
        $data->icon         = $param['icon'];
        $data->sort_id      = $param['sort_id'];
        $data->is_show      = $param['is_show'];
        $data->log_method   = $param['log_method'];

        return $data->save();
    }

    /**
     * 根据菜单id，删除菜单
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:27:20
     */
    public function destroy($id)
    {
        //判断是否有子菜单
        $have_son = AdminMenu::whereIn('parent_id', $id)->first();

        if ($have_son) {
            return error('有子菜单不可删除！');
        }

        $noDeletionId = (new AdminMenu())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        return AdminMenu::destroy($id);
    }


}