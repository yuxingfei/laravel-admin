<?php
/**
 * 后台管理员操作日志数据模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class AdminLogData extends BaseModel
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'admin_log_data';

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
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['data'];

    /**
     * 关联log
     *
     * @return BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:50
     */
    public function adminLog(): BelongsTo
    {
        return $this->belongsTo(AdminLog::class,'admin_log_id','id');
    }

    /**
     * 获取data
     *
     * @param $value
     * @return false|string
     * Author: Stephen
     * Date: 2020/5/18 16:50
     */
    public function getDataAttribute($value)
    {
        $data = Crypt::decrypt($value, env('APP_KEY'));
        return json_encode(json_decode($data, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
}
