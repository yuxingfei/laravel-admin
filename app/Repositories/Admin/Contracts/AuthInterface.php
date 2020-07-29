<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:01
 */

namespace App\Repositories\Admin\Contracts;

interface AuthInterface
{
    /**
     * 是否登录
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:50:57
     */
    public function isLogin();

    /**
     * 登录校验
     *
     * @param array $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 15:51:37
     */
    public function checkLogin(array $param);

    /**
     * 登录日志
     *
     * @param $loginUserId
     * Author: Stephen
     * Date: 2020/7/27 15:52:59
     */
    public function loginLog($loginUserId) :void ;

    /**
     * 后台操作日志数据
     *
     * @param $url
     * @param $loginUser
     * @param $menu
     * Author: Stephen
     * Date: 2020/7/27 15:53:11
     */
    public function adminLog($url,$loginUser,$menu) :void ;

}