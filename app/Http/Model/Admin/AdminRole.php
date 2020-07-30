<?php
/**
 * 后台角色模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Admin;

class AdminRole extends BaseModel
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin_role';

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


    protected $searchField = [
        'name',
        'description'
    ];

    public $noDeletionId = [
        1
    ];

    /**
     * 事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:51
     */
    protected static function booted()
    {
        //添加首页，系统管理，个人资料菜单/权限
        static::creating(function ($user) {
            //名称验重
            if(AdminRole::where('name',$user->name)->count() > 0){
                error('该名称已存在');
            }
            $user->url = [1, 2, 18];
        });
    }

    /**
     * 获取url
     *
     * @param $value
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 16:51
     */
    protected function getUrlAttribute($value)
    {
        return $value !== '' ? explode(',', $value) : [];
    }

    /**
     * 设置url
     *
     * @param $value
     * Author: Stephen
     * Date: 2020/5/18 16:52
     */
    protected function setUrlAttribute($value)
    {
        $this->attributes['url'] = $value !== '' ? implode(',', $value) : '';
    }

}
