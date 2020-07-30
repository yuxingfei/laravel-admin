<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:01
 */

namespace App\Repositories\Admin\Contracts;

use App\Http\Model\Admin\AdminUser;

interface AdminUserInterface
{
    /**
     * 用户首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:43:13
     */
    public function getPageData($param,$perPage);

    /**
     * 修改用户昵称
     *
     * @param $param
     * @param AdminUser $loginUser
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:43:39
     */
    public function updateNickName($param,AdminUser $loginUser);

    /**
     * 修改用户密码
     *
     * @param $param
     * @param AdminUser $loginUser
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:43:52
     */
    public function updatePassword($param,AdminUser $loginUser);

    /**
     * 修改用户头像
     *
     * @param AdminUser $loginUser
     * @param $file
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:44:03
     */
    public function updateAvatar(AdminUser $loginUser,$file);

    /**
     * 创建用户
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:44:12
     */
    public function create($param);

    /**
     * 根据id查找用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:44:22
     */
    public function findById($id);

    /**
     * 修改用户信息
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:44:33
     */
    public function update($param);

    /**
     * 启用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:44:56
     */
    public function enable($id);

    /**
     * 禁用
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:45:03
     */
    public function disable($id);

    /**
     * 删除用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:45:11
     */
    public function destroy($id);

    /**
     * 获取所有用户
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:45:21
     */
    public function all();

}