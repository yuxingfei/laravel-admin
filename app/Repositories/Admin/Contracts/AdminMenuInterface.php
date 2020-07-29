<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:01
 */

namespace App\Repositories\Admin\Contracts;

interface AdminMenuInterface
{
    /**
     * 通过id查找
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:30:36
     */
    public function find($id);

    /**
     * 通过url查找数据
     *
     * @param $url
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:31:15
     */
    public function findBy($url);

    /**
     * 通过route_name查找菜单
     *
     * @param $routeName
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 17:25:11
     */
    public function findByRouteName($routeName);

    /**
     * 查询所有菜单
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:32:33
     */
    public function allMenu();

    /**
     * 除去当前id之外的所有菜单id
     *
     * @param int $current_id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:34:48
     */
    public function menu($current_id = 0);

    /**
     * 获取模型中logMethod属性
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:35:55
     */
    public function getLogMethod();

    /**
     * 创建菜单
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:36:17
     */
    public function create($param);

    /**
     * 插入多条菜单数据
     *
     * @param $data
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:36:29
     */
    public function insert($data);

    /**
     * 根据菜单id，删除菜单
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:36:46
     */
    public function destroy($id);

    /**
     * 修改菜单数据
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:37:05
     */
    public function update($param);

}