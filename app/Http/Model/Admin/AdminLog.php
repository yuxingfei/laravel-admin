<?php
/**
 * 后台操作日志模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdminLog extends BaseModel
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table      = 'admin_log';

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
    public $timestamps    = true;

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
    protected $guarded    = [];

    /**
     * @var array 请求方法
     */
    public $methodText    = [
        1 => 'GET',
        2 => 'POST',
        3 => 'PUT',
        4 => 'DELETE',
    ];

    /**
     * @var array 允许搜索的字段
     */
    protected $searchField = [
        'name',
        'url',
        'log_ip'
    ];

    //可作为条件的字段
    protected $whereField  = [
        'admin_user_id'
    ];

    protected $timeField   = [
        'create_time'
    ];

    /**
     * 关联用户
     *
     * @return BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:49
     */
    public function adminUser(): BelongsTo
    {
        return $this->belongsTo('App\Http\Model\Admin\AdminUser');
    }

    /**
     * 关联详情
     *
     * @return HasOne
     * Author: Stephen
     * Date: 2020/5/18 16:49
     */
    public function adminLogData(): HasOne
    {
        return $this->hasOne('App\Http\Model\Admin\AdminLogData');
    }

}
