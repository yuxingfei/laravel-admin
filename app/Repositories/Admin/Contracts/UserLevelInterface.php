<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 15:23
 */

namespace App\Repositories\Admin\Contracts;


interface UserLevelInterface
{

    /**
     * 根据条件获取用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:20:49
     */
    public function get($param);

    /**
     * 用户等级首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:21:05
     */
    public function getPageData($param,$perPage);

    /**
     * 创建用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:21:21
     */
    public function create($param);

    /**
     * 根据id查找用户等级信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:21:32
     */
    public function findById($id);

    /**
     * 更新用户等级
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:22:05
     */
    public function update($param);

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:22:16
     */
    public function enable($id);

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:22:25
     */
    public function disable($id);

    /**
     * 删除用户等级
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:22:34
     */
    public function destroy($id);

}