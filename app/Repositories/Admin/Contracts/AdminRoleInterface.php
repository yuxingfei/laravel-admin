<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:01
 */

namespace App\Repositories\Admin\Contracts;

interface AdminRoleInterface
{
    /**
     * 角色首页数据查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:37:27
     */
    public function getPageData($param,$perPage);

    /**
     * 创建角色
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:40:28
     */
    public function create($param);

    /**
     * 通过id查找角色
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:40:39
     */
    public function findById($id);

    /**
     * 更新角色信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:40:56
     */
    public function update($param);

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:41:09
     */
    public function enable($id);

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:41:18
     */
    public function disable($id);

    /**
     * 存储授权信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:41:29
     */
    public function storeAccess($param);

    /**
     * 删除角色信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:42:23
     */
    public function destroy($id);

    /**
     * 获取所有的角色
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:42:37
     */
    public function all();

}