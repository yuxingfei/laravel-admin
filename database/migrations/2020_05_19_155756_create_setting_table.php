<?php
/**
 * 设置表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('setting_group_id')->default('0')->comment('所属分组');
            $table->string('name', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('名称');
            $table->string('description', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('描述');
            $table->string('code', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('代码');
            $table->text('content')->collation('utf8mb4_unicode_ci')->comment('设置配置及内容');
            $table->unsignedInteger('sort_number')->default('1000')->comment('排序');
            $table->unsignedInteger('create_time')->default('0')->comment('创建时间');
            $table->unsignedInteger('update_time')->default('0')->comment('更新时间');
            $table->unsignedInteger('delete_time')->default('0')->comment('删除时间');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '设置';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
