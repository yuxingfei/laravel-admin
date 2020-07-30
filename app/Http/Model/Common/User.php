<?php
/**
 * 用户模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends BaseModel
{

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'user';

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

    //可搜索字段
    protected $searchField = ['username', 'mobile', 'nickname',];

    /**
     * 模型事件
     *
     * Author: Stephen
     * Date: 2020/5/18 16:59
     */
    protected static function booted()
    {
        //添加自动加密密码
        static::creating(function ($user) {
            //添加自动加密密码
            $user->password = base64_encode(password_hash($user->password, 1));
        });

        //修改密码自动加密
        static::updating(function ($user) {
            //修改密码自动加密
            $old = User::find($user->id);
            if ($user->password !== $old->password) {
                $user->password = base64_encode(password_hash($user->password, 1));
            }
        });
    }

    /**
     * 关联用户等级
     *
     * @return BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:59
     */
    public function userLevel(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class);
    }

    /**
     * 用户登录
     *
     * @param $param
     * @return mixed
     * Author: Stephen
     * Date: 2020/5/18 16:59
     */
    public static function login($param)
    {
        $username = $param['username'];
        $password = $param['password'];

        $user     = self::where(['username' => $username])->first();

        if (!$user) {
            exception('用户不存在');
        }

        if (!password_verify($password, base64_decode($user->password))) {
            exception('密码错误');
        }

        if ((int)$user->status !== 1) {
            exception('用户被冻结');
        }

        return $user;
    }

    /**
     * 加密字符串，用在登录的时候加密处理
     *
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:59
     */
    protected function getSignStrAttribute()
    {
        $ua = request()->header('user-agent');

        return sha1($this->attributes['id'] . $this->attributes['username'] . $ua);
    }
}
