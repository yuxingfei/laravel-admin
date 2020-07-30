<?php
/**
 * 设置分组模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

class SettingGroup extends BaseModel
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'setting_group';

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
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];


    public $noDeletionId  =[
        1,2,3,4,5,
    ];

    //可搜索字段
    protected $searchField = ['name', 'description', 'code',];

    /**
     * 模型事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:58
     */
    protected static function booted()
    {
        //添加首页，系统管理，个人资料菜单/权限
        static::creating(function ($settingGroup) {
            //名称验重
            if(SettingGroup::where('code',$settingGroup->code)->count() > 0){
                error('code已存在');
            }
        });
    }

    /**
     * 关联设置
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Author: Stephen
     * Date: 2020/5/18 16:58
     */
    public function setting()
    {
        return $this->hasMany(Setting::class);
    }

}
