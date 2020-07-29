<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 16:25
 */

namespace App\Repositories\Admin\Contracts;


interface SettingGroupInterface
{
    /**
     * 通过id查找数据
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:14:31
     */
    public function findById($id);

    /**
     * 首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:14:51
     */
    public function getPageDataForAll($param,$perPage);

    /**
     * 获取所有的设置分组
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:15:13
     */
    public function getSettingGroupList();

    /**
     * 创建设置分组
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:15:30
     */
    public function create($param);

    /**
     * 根据id删除设置分组
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:15:42
     */
    public function destroy($id);

}