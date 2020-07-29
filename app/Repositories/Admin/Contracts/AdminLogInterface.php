<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/17
 * Time: 15:23
 */

namespace App\Repositories\Admin\Contracts;


interface AdminLogInterface
{
    /**
     * 首页查询
     *
     * @param $param
     * @param $perPage
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:29:56
     */
    public function getPageData($param,$perPage);

    /**
     * 通过id查找日志记录
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:30:10
     */
    public function find($id);

}