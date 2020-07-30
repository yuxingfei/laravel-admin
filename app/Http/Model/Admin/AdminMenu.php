<?php
/**
 * 后台菜单(权限)模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Admin;

class AdminMenu extends BaseModel
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin_menu';

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
    protected $guarded = ['is_more','more_name'];


    public $logMethod = [
        0 => '不记录',
        1 => 'GET',
        2 => 'POST',
        3 => 'PUT',
        4 => 'DELETE'
    ];

    /**
     * @var array 不允许删除的id
     */
    public $noDeletionId = [
        1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20
    ];

    /**
     * 事件
     *
     * Author: Stephen
     * Date: user_define_date
     */
    protected static function booted()
    {
        //添加首页，菜单管理，添加菜单
        static::creating(function ($admin_menu) {
            //url验重
            if(self::where('url',$admin_menu->url)->count() > 0){
                error('该url已存在');
            }
            //route_name验重
            if(self::where('route_name',$admin_menu->route_name)->count() > 0){
                error('该route_name已存在');
            }
        });
    }


}