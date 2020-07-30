<?php
/**
 * Demo 用户等级 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Attachment;
use App\Http\Model\Common\UserLevel;
use App\Repositories\Admin\Contracts\UserLevelInterface;

class UserLevelRepository implements UserLevelInterface
{
    /**
     * 根据条件获取用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:38:53
     */
    public function get($param)
    {
        return UserLevel::addWhere($param)->get();
    }

    /**
     * 用户等级首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:38:59
     */
    public function getPageData($param, $perPage)
    {
        return UserLevel::addWhere($param)->paginate($perPage);
    }

    /**
     * 创建用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:39:09
     */
    public function create($param)
    {
        return UserLevel::create($param);
    }

    /**
     * 根据id查找用户等级信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:39:24
     */
    public function findById($id)
    {
        return UserLevel::find($id);
    }

    /**
     * 更新用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:39:37
     */
    public function update($param)
    {
        $data = $this->findById($param['id']);

        //处理图片上传
        if (!empty(request()->file('img'))) {
            $attachment_img = new Attachment();
            $file_img       = $attachment_img->upload('img');
            if ($file_img) {
                $data ->img = $file_img->url;
            }
        }

        $data->name        = $param['name'];
        $data->description = $param['description'];
        $data->status      = $param['status'];

        return $data->save();
    }

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:39:51
     */
    public function enable($id)
    {
        return UserLevel::whereIn('id', $id)->update(['status' => 1]);
    }

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:40:02
     */
    public function disable($id)
    {
        return UserLevel::whereIn('id', $id)->update(['status' => 0]);
    }

    /**
     * 删除用户等级
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:40:13
     */
    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $noDeletionId = (new UserLevel())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = UserLevel::destroy($id);

        return $count;
    }

}