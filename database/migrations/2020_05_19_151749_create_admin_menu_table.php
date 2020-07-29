<?php
/**
 * 后台菜单 数据表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateAdminMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menu', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('parent_id')->default('0')->comment('父级菜单');
            $table->string('name', 30)->collation('utf8mb4_unicode_ci')->default('')->comment('名称');
            $table->string('url', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('url');
            $table->string('route_name', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('路由名或者路由标识');
            $table->string('icon', 30)->collation('utf8mb4_unicode_ci')->default('fa-list')->comment('图标');
            $table->tinyInteger('is_show')->default('1')->comment('等级');
            $table->unsignedInteger('sort_id')->default('1000')->comment('排序');
            $table->string('log_method', 8)->collation('utf8mb4_unicode_ci')->default('不记录')->comment('记录日志方法');

            //创建url的索引
            $table->index('url','index_url');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '后台菜单';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu');
    }
}
