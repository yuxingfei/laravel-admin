<?php
/**
 * 设置分组
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateSettingGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_group', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('module', 30)->collation('utf8mb4_unicode_ci')->default('')->comment('作用模块');
            $table->string('name', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('名称');
            $table->string('description', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('描述');
            $table->string('code', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('代码');
            $table->unsignedInteger('sort_number')->default('1000')->comment('排序');
            $table->tinyInteger('auto_create_menu')->default('0')->comment('自动生成菜单');
            $table->tinyInteger('auto_create_file')->default('0')->comment('自动生成配置文件');
            $table->string('icon', 30)->collation('utf8mb4_unicode_ci')->default('fa-list')->comment('图标');
            $table->unsignedInteger('create_time')->default('0')->comment('创建时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');
            $table->unsignedInteger('delete_time')->default('0')->comment('删除时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '设置分组';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_group');
    }
}
