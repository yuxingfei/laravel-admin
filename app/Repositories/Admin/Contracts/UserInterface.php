<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 15:23
 */

namespace App\Repositories\Admin\Contracts;


interface UserInterface
{
    /**
     * 用户管理首页
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:18:22
     */
    public function getPageData($param,$perPage);

    /**
     * 根据条件获取用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:18:54
     */
    public function get($param);

    /**
     * 创建用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:19:09
     */
    public function create($param);

    /**
     * 根据id查找用户信息
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:19:21
     */
    public function findById($id);

    /**
     * 修改用户信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:19:50
     */
    public function update($param);

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:20:07
     */
    public function enable($id);

    /**
     * 禁用用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:20:15
     */
    public function disable($id);

    /**
     * 删除用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 16:20:23
     */
    public function destroy($id);

}