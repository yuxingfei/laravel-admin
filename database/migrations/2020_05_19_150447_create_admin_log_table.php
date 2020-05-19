<?php
/**
 * 创建后台操作日志表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateAdminLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_log', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('admin_user_id')->default('0')->comment('用户id');
            $table->string('name', 30)->collation('utf8mb4_unicode_ci')->default('')->comment('操作');
            $table->string('url', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('URL');
            $table->string('log_method', 8)->collation('utf8mb4_unicode_ci')->default('不记录')->comment('记录日志方法');
            $table->string('log_ip', 20)->collation('utf8mb4_unicode_ci')->default('')->comment('操作IP');
            $table->unsignedInteger('create_time')->default('0')->comment('操作时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '后台操作日志';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_log');
    }
}
