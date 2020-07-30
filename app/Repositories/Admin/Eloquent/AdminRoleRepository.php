<?php
/**
 * 用户角色 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Admin\AdminRole;

use App\Repositories\Admin\Contracts\AdminRoleInterface;

class AdminRoleRepository implements AdminRoleInterface
{
    /**
     * 角色首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:28:26
     */
    public function getPageData($param, $perPage)
    {
        return AdminRole::addWhere($param)->paginate($perPage);
    }

    /**
     * 创建角色
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:28:33
     */
    public function create($param)
    {
        return AdminRole::create($param);
    }

    /**
     * 通过id查找角色
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:28:48
     */
    public function findById($id)
    {
        return AdminRole::find($id);
    }

    /**
     * 更新角色信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:29:01
     */
    public function update($param)
    {
        $data = $this->findById($param['id']);

        $data->name        = $param['name'];
        $data->description = $param['description'];
        $data->status      = $param['status'];

        return $data->save();
    }

    /**
     * 删除角色信息
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:29:15
     */
    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $noDeletionId = (new AdminRole())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = AdminRole::destroy($id);

        return $count;

    }

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:29:30
     */
    public function enable($id)
    {
        return AdminRole::whereIn('id', $id)->update(['status' => 1]);
    }

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:29:44
     */
    public function disable($id)
    {
        return AdminRole::whereIn('id', $id)->update(['status' => 0]);
    }

    /**
     * 存储授权信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:29:55
     */
    public function storeAccess($param)
    {
        $data = $this->findById($param['id']);
        asort( $param['url']);
        $data->url = $param['url'];

        return $data->save();
    }

    /**
     * 获取所有的角色
     *
     * @return AdminRole[]|\Illuminate\Database\Eloquent\Collection|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:30:06
     */
    public function all()
    {
        return AdminRole::all();
    }


}