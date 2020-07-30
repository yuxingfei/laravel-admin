<?php
/**
 * 设置分组 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\SettingGroup;
use App\Repositories\Admin\Contracts\SettingGroupInterface;

class SettingGroupRepository implements SettingGroupInterface
{
    /**
     * 通过id查找数据
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:36:03
     */
    public function findById($id)
    {
        return SettingGroup::find($id);
    }

    /**
     * 首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:36:09
     */
    public function getPageDataForAll($param, $perPage)
    {
        return SettingGroup::addWhere($param)->paginate($perPage);
    }

    /**
     * 获取所有的设置分组
     *
     * @return SettingGroup[]|\Illuminate\Database\Eloquent\Collection|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:36:20
     */
    public function getSettingGroupList()
    {
        return SettingGroup::all();
    }

    /**
     * 创建设置分组
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:36:33
     */
    public function create($param)
    {
        return SettingGroup::create($param);
    }

    /**
     * 根据id删除设置分组
     *
     * @param $id
     * @return int|mixed
     * Author: Stephen
     * Date: 2020/7/27 16:36:44
     */
    public function destroy($id)
    {
        return SettingGroup::destroy($id);
    }


}