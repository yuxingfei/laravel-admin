<?php
/**
 * 附件模型
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'attachment';

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
     * 可以被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['admin_user_id','user_id','original_name','save_name','save_path','url','extension','mime','size','md5','sha1'];

    /**
     * 错误信息
     * @var mixed
     */
    protected $error;

    protected $fileType = [
        '图片'   => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
        '文档'   => ['txt', 'doc', 'docx', 'xls', 'xlsx', 'pdf'],
        '压缩文件' => ['rar', 'zip', '7z', 'tar'],
        '音视'   => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
        '视频'   => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
    ];

    protected $fileThumb = [
        'picture'      => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
        'txt.svg'      => ['txt', 'pdf'],
        'pdf.svg'      => ['pdf'],
        'word.svg'     => ['doc', 'docx'],
        'excel.svg'    => ['xls', 'xlsx'],
        'archives.svg' => ['rar', 'zip', '7z', 'tar'],
        'audio.svg'    => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
        'video.svg'    => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
    ];

    /**
     * 关联后台用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:54
     */
    public function adminUser()
    {
        return $this->belongsTo('AdminUser', 'admin_user_id', 'id');
    }

    /**
     * 关联前台用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Author: Stephen
     * Date: 2020/5/18 16:54
     */
    public function User()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

    /**
     * 格式化大小
     *
     * @param $value
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:55
     */
    public function getSizeAttr($value)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $value >= 1024 && $i < 4; $i++) {
            $value /= 1024;
        }

        return round($value, 2) . $units[$i];
    }

    /**
     * 文件分类
     *
     * @return int|string
     * Author: Stephen
     * Date: 2020/5/18 16:55
     */
    public function getFileTypeAttribute()
    {
        $type      = '其他';
        $extension = $this->getAttribute('extension');
        foreach ($this->fileType as $name => $array) {
            if (in_array($extension, $array)) {
                $type = $name;
                break;
            }
        }

        return $type;
    }

    /**
     * 文件预览
     *
     * @return int|mixed|string
     * Author: Stephen
     * Date: 2020/5/18 16:55
     */
    public function getThumbnailAttribute()
    {
        $thumbnail = config('Admin.attachment.thumb_path') . 'unknown.svg';
        $extension = $this->getAttribute('extension');

        $thumb_path      = config('Admin.attachment.thumb_path');
        $fileThumb = [
            'picture'                    => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
            $thumb_path . 'txt.svg'      => ['txt', 'pdf'],
            $thumb_path . 'pdf.svg'      => ['pdf'],
            $thumb_path . 'word.svg'     => ['doc', 'docx'],
            $thumb_path . 'excel.svg'    => ['xls', 'xlsx'],
            $thumb_path . 'archives.svg' => ['rar', 'zip', '7z', 'tar'],
            $thumb_path . 'audio.svg'    => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
            $thumb_path . 'video.svg'    => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
        ];

        foreach ($fileThumb as $name => $array) {
            if (in_array($extension, $array)) {
                $thumbnail = $name === 'picture' ? $this->getAttribute('url') : $name;
                break;
            }
        }

        return $thumbnail;
    }

    /**
     * 获取fileUrl
     *
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:55
     */
    public function getFileUrlAttribute()
    {
        $request = request();
        $url_pre = $request->getScheme() . '://' . $request->getHost();
        return $url_pre . $this->getAttribute('url');
    }

    /**
     * 上传
     *
     * @param $name
     * @param string $path
     * @param array $validate
     * @param int $admin_user_id
     * @param int $user_id
     * @return mixed
     * Author: Stephen
     * Date: 2020/5/18 16:56
     */
    public function upload($name, $path = '', $validate = [], $admin_user_id = 0, $user_id = 0){
        $file = request()->file($name);
        if($file && $file->isValid()){
            $uploadFileUrl = $file->store('attachment','public');
            if($uploadFileUrl){
                $admin_user_id = (session()->has('admin_user_id') && session()->get('admin_user_id') != 0) ? session()->get('admin_user_id') : 0;
                $file_info = [
                    'admin_user_id' => $admin_user_id,
                    'user_id'       => $user_id,
                    'original_name' => $file->getClientOriginalName(),
                    'save_name'     => $file->hashName(),
                    'save_path'     => storage_path('app/public/').$uploadFileUrl,
                    'url'           => '/storage/'.$uploadFileUrl,
                    'extension'     => $file->getClientOriginalExtension(),
                    'mime'          => $file->getClientMimeType(),
                    'size'          => $file->getSize(),
                    'md5'           => md5($file->hashName()),
                    'sha1'          => sha1($file->hashName()),
                ];
                return self::create($file_info);
            }else{
                $this->error = $file->getError();
            }

        }else{
            $this->error = '无法获取文件';
        }
    }

    /**
     * 上传多个文件
     *
     * @param $name
     * @param string $path
     * @param array $validate
     * @param int $admin_user_id
     * @param int $user_id
     * @return array|bool
     * Author: Stephen
     * Date: 2020/5/18 16:56
     */
    public function uploadMulti($name, $path = '', $validate = [], $admin_user_id = 0, $user_id = 0)
    {
        $result = [];

        $files = request()->file($name);
        if(!empty($files)){
            foreach ($files as $file){
                $uploadFileUrl = $file->store('attachment','public');
                if($uploadFileUrl){
                    $admin_user_id = (session()->has('admin_user_id') && session()->get('admin_user_id') != 0) ? session()->get('admin_user_id') : 0;
                    $file_info = [
                        'admin_user_id' => $admin_user_id,
                        'user_id'       => $user_id,
                        'original_name' => $file->getClientOriginalName(),
                        'save_name'     => $file->hashName(),
                        'save_path'     => storage_path('app/public/').$uploadFileUrl,
                        'url'           => '/storage/'.$uploadFileUrl,
                        'extension'     => $file->getClientOriginalExtension(),
                        'mime'          => $file->getClientMimeType(),
                        'size'          => $file->getSize(),
                        'md5'           => md5($file->hashName()),
                        'sha1'          => sha1($file->hashName()),
                    ];
                    $file_item = self::create($file_info);
                    $result[]  = $file_item->url;
                }else{
                    $this->error = $file->getError();
                }
            }
            if (count($result) > 0) {
                return $result;
            }

            return false;
        }
        $this->error = '无法获取文件';
        return false;
    }

    /**
     * 获取错误信息
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/5/18 16:56
     */
    public function getError()
    {
        return $this->error;
    }

}
