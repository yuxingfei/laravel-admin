<?php
/**
 * Demo 用户管理 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Attachment;
use App\Http\Model\Common\User;
use App\Repositories\Admin\Contracts\UserInterface;

class UserRepository implements UserInterface
{
    /**
     * 用户管理首页
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:40:51
     */
    public function getPageData($param, $perPage)
    {
        return User::with('userLevel')->addWhere($param)->paginate($perPage);
    }

    /**
     * 根据条件获取用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:40:59
     */
    public function get($param)
    {
        return User::with('userLevel')->addWhere($param)->get();
    }

    /**
     * 创建用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:41:10
     */
    public function create($param)
    {
        return User::create($param);
    }

    /**
     * 根据id查找用户信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:41:28
     */
    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * 修改用户信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:41:40
     */
    public function update($param)
    {
        $data = $this->findById($param['id']);

        //处理头像上传
        if (!empty(request()->file('avatar'))) {
            $attachment_avatar = new Attachment();
            $file_avatar       = $attachment_avatar->upload('avatar');
            if ($file_avatar) {
                $data->avatar = $file_avatar->url;
            }
        }
        $data->user_level_id = $param['user_level_id'];
        $data->username      = $param['username'];
        $data->mobile        = $param['mobile'];
        $data->nickname      = $param['nickname'];
        $data->password      = $param['password'];
        $data->status        = $param['status'];
        $data->description   = isset($param['description']) ? $param['description'] : '';

        return $data->save();
    }

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:41:53
     */
    public function enable($id)
    {
        return User::whereIn('id', $id)->update(['status' => 1]);
    }

    /**
     * 禁用用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:42:03
     */
    public function disable($id)
    {
        return User::whereIn('id', $id)->update(['status' => 0]);
    }

    /**
     * 删除用户
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:42:15
     */
    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $noDeletionId = (new User())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = User::destroy($id);

        return $count;
    }

}