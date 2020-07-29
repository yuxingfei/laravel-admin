<?php
/**
 * 后台 基础服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/12
 * Time: 14:17
 */

namespace App\Services;


use Illuminate\Support\Facades\Cookie;

class AdminBaseService
{
    /**
     * 每页显示多少条
     *
     * @return array|int|string|null
     * Author: Stephen
     * Date: 2020/7/27 16:53:12
     */
    public function perPage()
    {
        $perPage = Cookie::get('admin_per_page') ?? 10;

        return $perPage < 100 ? $perPage : 100;
    }

}