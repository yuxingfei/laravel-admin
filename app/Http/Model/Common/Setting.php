<?php
/**
 * 设置模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

class Setting extends BaseModel
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'setting';

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
     * 可批量赋值的属性。
     *
     * @var array
     */
    protected $fillable  = ['setting_group_id','name','description','code','content','sort_number'];

    public $noDeletionId = [
        1, 2, 3, 4, 5,
    ];

    //可搜索字段
    protected $searchField = ['name', 'description', 'code',];

    /**
     * 模型事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:57
     */
    protected static function booted()
    {
        //添加首页，系统管理，个人资料菜单/权限
        static::creating(function ($setting) {
            //名称验重
            if(Setting::where('code',$setting->code)->count() > 0){
                error('code已存在');
            }
        });
    }

    /**
     * 关联设置分组
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:57
     */
    public function settingGroup()
    {
        return $this->belongsTo(SettingGroup::class);
    }

    /**
     * 设置content
     *
     * @param $value
     * Author: Stephen
     * Date: 2020/5/18 16:58
     */
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }

    /**
     * 获取content
     *
     * @param $value
     * @return mixed
     * Author: Stephen
     * Date: 2020/5/18 16:58
     */
    public function getContentAttribute($value)
    {
        return json_decode($value, true);
    }


}
