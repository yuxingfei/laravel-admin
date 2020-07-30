<?php
/**
 * 用户等级模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

class UserLevel extends BaseModel
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'user_level';

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

    /**
     * @var array  可搜索字段
     */
    protected $searchField = ['name', 'description',];

    /**
     * 关联用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Author: Stephen
     * Date: 2020/5/18 17:00
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }


}
