<?php
/**
 * 案例-用户表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('avatar', 255)->collation('utf8mb4_unicode_ci')->default('/static/index/images/avatar.png')->comment('头像');
            $table->string('username', 30)->collation('utf8mb4_unicode_ci')->default('')->comment('用户名');
            $table->string('nickname', 30)->collation('utf8mb4_unicode_ci')->default('')->comment('昵称');
            $table->string('mobile', 11)->collation('utf8mb4_unicode_ci')->default('')->comment('手机号');
            $table->unsignedInteger('user_level_id')->default('1')->comment('用户等级');
            $table->string('password', 255)->collation('utf8mb4_unicode_ci')->default('JDJ5JDEwJGUvaXZQcUMvbHBFcHUvVm16RWRrbU9ROFROYlMvMktwZnZqaGhWQ29uUi5GTGQ5Sng3SzlD')->comment('密码');
            $table->tinyInteger('status')->default('1')->comment('是否启用 0：否 1：是');
            $table->text('description')->collation('utf8mb4_unicode_ci')->comment('描述');
            $table->unsignedInteger('create_time')->default('0')->comment('创建时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');
            $table->unsignedInteger('delete_time')->default('0')->comment('删除时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '用户';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
