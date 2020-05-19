<?php
/**
 * 后台角色表
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateAdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role', function (Blueprint $table) {

            //表的字段
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('name', 50)->collation('utf8mb4_unicode_ci')->default('')->comment('名称');
            $table->string('description', 100)->collation('utf8mb4_unicode_ci')->default('')->comment('简介');
            $table->string('url', 1000)->collation('utf8mb4_unicode_ci')->default('')->comment('权限');
            $table->tinyInteger('status')->default('1')->comment('是否启用');

            //表的属性
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            //表注释
            $table->comment = '后台角色';

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role');
    }
}
