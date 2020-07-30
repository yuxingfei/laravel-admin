<?php
/**
 * 用户管理 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Admin\AdminUser;

use App\Repositories\Admin\Contracts\AdminUserInterface;

class AdminUserRepository implements AdminUserInterface
{
    /**
     * 修改用户昵称
     *
     * @param $param
     * @param AdminUser $loginUser
     * @return bool|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:30:55
     */
    public function updateNickName($param,AdminUser $loginUser)
    {
        $loginUser->nickname = $param['nickname'];

        return $loginUser->save();
    }

    /**
     * 修改用户密码
     *
     * @param $param
     * @param AdminUser $loginUser
     * @return bool|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:31:13
     */
    public function updatePassword($param,AdminUser $loginUser)
    {
        $loginUser->password = $param['new_password'];

        return $loginUser->save();
    }

    /**
     * 修改用户头像
     *
     * @param AdminUser $loginUser
     * @param $file
     * @return bool|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:31:28
     */
    public function updateAvatar(AdminUser $loginUser,$file)
    {
        $loginUser->avatar = $file->url;

        return $loginUser->save();
    }

    /**
     * 用户首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:30:38
     */
    public function getPageData($param, $perPage)
    {
        return AdminUser::addWhere($param)->paginate($perPage);
    }

    /**
     * 创建用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:31:43
     */
    public function create($param)
    {
        return AdminUser::create($param);
    }

    /**
     * 根据id查找用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:31:58
     */
    public function findById($id)
    {
        return AdminUser::find($id);
    }

    /**
     * 修改用户信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:32:10
     */
    public function update($param)
    {
        $data = $this->findById($param['id']);

        $data->role     = $param['role'];
        $data->nickname = $param['nickname'];
        $data->username = $param['username'];
        $data->password = $param['password'];
        $data->status   = $param['status'];

        return $data->save();
    }

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:32:21
     */
    public function enable($id)
    {
        return AdminUser::whereIn('id', $id)->update(['status' => 1]);
    }

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:32:32
     */
    public function disable($id)
    {
        return AdminUser::whereIn('id', $id)->update(['status' => 0]);
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:32:42
     */
    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $noDeletionId = (new AdminUser())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = AdminUser::destroy($id);

        return $count;
    }

    /**
     * 获取所有用户
     *
     * @return AdminUser[]|\Illuminate\Database\Eloquent\Collection|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:33:00
     */
    public function all()
    {
        return AdminUser::all();
    }


}