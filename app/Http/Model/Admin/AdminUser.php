<?php

/**
 * AdminUser
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Http\Model\Admin;

class AdminUser extends BaseModel
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin_user';

    /**
     * 重定义主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 可搜索字段
     *
     * @var array
     */
    protected $searchField = [
        'nickname',
        'username'
    ];

    /**
     * 模型事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:52
     */
    protected static function booted()
    {
        //添加自动加密密码
        static::creating(function ($adminUser) {
            //账号验重
            if(AdminUser::where('username',$adminUser->username)->count() > 0){
                error('该账号已注册');
            }

            $adminUser->password = base64_encode(password_hash($adminUser->password, 1));
        });

        //修改密码自动加密
        static::updating(function ($adminUser) {
            $old = AdminUser::find($adminUser->id);
            if ($adminUser->password !== $old->password) {
                $adminUser->password = base64_encode(password_hash($adminUser->password, 1));
            }
        });
    }

    /**
     * 加密字符串，用在登录的时候加密处理
     *
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:52
     */
    public function getSignStrAttribute()
    {
        $ua = request()->header('user-agent');
        return sha1($this->getAttribute('id') . $this->getAttribute('username') . $ua);
    }

    /**
     * 角色获取器
     *
     * @param $value
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:52
     */
    protected function getRoleAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * 角色修改器
     *
     * @param $value
     * Author: Stephen
     * Date: 2020/5/18 16:53
     */
    protected function setRoleAttribute($value)
    {
        $this->attributes['role'] = implode(',', $value);
    }

    /**
     * 获取已授权url
     *
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:53
     */
    protected function getAuthUrlAttribute()
    {
        $role_urls  = AdminRole::whereIn('id',$this->getAttribute('role'))->where('status', 1)->pluck('url')->toArray();
        $url_id = [];
        foreach ($role_urls as $key => $val) {
            $url_id = array_merge($url_id,$val);
        }
        $url_id = array_values(array_unique($url_id));

        $auth_url = [];
        if (count($url_id) > 0) {
            $auth_url = AdminMenu::whereIn('id', $url_id)->pluck('url')->toArray();
        }

        return $auth_url;
    }

    /**
     * 获取已授权route_name
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 15:35:21
     */
    protected function getAuthRouteNameAttribute()
    {
        $role_urls  = AdminRole::whereIn('id',$this->getAttribute('role'))->where('status', 1)->pluck('url')->toArray();
        $url_id = [];
        foreach ($role_urls as $key => $val) {
            $url_id = array_merge($url_id,$val);
        }
        $url_id = array_values(array_unique($url_id));

        $authRouteName = [];
        if (count($url_id) > 0) {
            $authRouteName = AdminMenu::whereIn('id', $url_id)->where('route_name','<>','')->pluck('route_name')->toArray();
        }

        return $authRouteName;
    }

    /**
     * 获取当前用户已授权的显示菜单
     *
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:53
     */
    public function getShowMenu()
    {
        if ($this->getAttribute('id') === 1) {
            $menu = AdminMenu::where('is_show', 1)
                ->orderBy('sort_id', 'asc')
                ->orderBy('id', 'asc')
                ->get(['id','parent_id','name','url','icon','sort_id','route_name'])
                ->toArray();
            return array_column($menu,NULL,'id');
        }

        $role_urls = AdminRole::whereIn('id', $this->getAttribute('role'))->where('status', 1)->pluck('url');

        $url_id = [];
        foreach ($role_urls as $key => $val) {
            $url_id = array_merge($url_id,$val);
        }
        $url_id = array_values(array_unique($url_id));
        $menu = AdminMenu::whereIn('id', $url_id)
            ->where('is_show', 1)
            ->orderBy('sort_id', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id','parent_id','name','url','icon','sort_id','route_name'])
            ->toArray();

        return array_column($menu,NULL,'id');

    }

    /**
     * 用户角色名称
     *
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:53
     */
    protected function getRoleTextAttribute()
    {
        $adminRole = AdminRole::whereIn('id', $this->getAttribute('role'))
            ->get(['id','name'])
            ->toArray();

        return array_column($adminRole,NULL,'id');
    }

}
