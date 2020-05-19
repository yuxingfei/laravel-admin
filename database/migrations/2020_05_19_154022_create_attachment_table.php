<?php
/**
 * 附件表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('attachment', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('admin_user_id')->default('0')->comment('后台用户ID');
            $table->unsignedInteger('user_id')->default('0')->comment('前台用户ID');
            $table->string('original_name', 200)->collation('utf8mb4_unicode_ci')->default('')->comment('原文件名');
            $table->string('save_name', 200)->collation('utf8mb4_unicode_ci')->default('')->comment('保存文件名');
            $table->string('save_path', 255)->collation('utf8mb4_unicode_ci')->default('')->comment('系统完整路径');
            $table->string('url', 255)->collation('utf8mb4_unicode_ci')->default('')->comment('网站url路径');
            $table->string('extension', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('后缀');
            $table->string('mime', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('类型');
            $table->bigInteger('size')->default('0')->comment('大小');
            $table->string('md5', 32)->collation('utf8mb4_unicode_ci')->default('')->comment('MD5');
            $table->string('sha1', 40)->collation('utf8mb4_unicode_ci')->default('')->comment('SHA1');
            $table->unsignedInteger('create_time')->default('0')->comment('创建时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');
            $table->unsignedInteger('delete_time')->default('0')->comment('删除时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '附件表';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachment');
    }
}
