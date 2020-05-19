<?php
/**
 * 用户等级
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateUserLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_level', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 20)->collation('utf8mb4_unicode_ci')->default('')->comment('名称');
            $table->string('description', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('简介');
            $table->string('img', 255)->collation('utf8mb4_unicode_ci')->default('/static/index/images/user_level_default.png')->comment('图片');
            $table->tinyInteger('status')->default('1')->comment('是否启用 0：否 1：是');
            $table->unsignedInteger('create_time')->default('0')->comment('创建时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');
            $table->unsignedInteger('delete_time')->default('0')->comment('删除时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '用户等级';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_level');
    }
}
