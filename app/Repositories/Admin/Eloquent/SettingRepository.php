<?php
/**
 * 设置中心 仓库
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:03
 */

namespace App\Repositories\Admin\Eloquent;

use App\Http\Model\Common\Setting;
use App\Repositories\Admin\Contracts\SettingInterface;

class SettingRepository implements SettingInterface
{
    /**
     * 根据设置分组id获取多个设置信息
     *
     * @param $settingGroupId
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:38:19
     */
    public function getDataBySettingGroupId($settingGroupId)
    {
        return Setting::where('setting_group_id', $settingGroupId)->get();
    }

    /**
     * 根据id查找设置信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:38:07
     */
    public function findById($id)
    {
        return Setting::find($id);
    }

    /**
     * 设置界面首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:37:51
     */
    public function getPageData($param, $perPage)
    {
        return Setting::with('settingGroup')->addWhere($param)->paginate($perPage);
    }

    /**
     * 创建设置数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:37:32
     */
    public function create($param)
    {
        return Setting::create($param);
    }

    /**
     * 删除设置数据
     *
     * @param $id
     * @return int|mixed|void
     * Author: Stephen
     * Date: 2020/7/27 16:37:11
     */
    public function destroy($id)
    {
        is_string($id) && $id = [$id];

        $noDeletionId = (new Setting())->getNoDeletionId();

        if (count($noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($noDeletionId, $id)) {
                    return error('ID为' . implode(',', $noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = Setting::destroy($id);

        return $count;
    }

}