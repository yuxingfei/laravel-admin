<?php
/**
 * Created by PhpStorm.
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/5
 * Time: 17:15
 */

namespace App\Facades;


use App\Repositories\Admin\Contracts\AuthInterface;
use Illuminate\Support\Facades\Facade;

class AuthFacade extends Facade
{
    protected static function getFacadeAccessor(){
        return AuthInterface::class;
    }

}