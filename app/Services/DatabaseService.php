<?php
/**
 * 数据库操作 服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/24
 * Time: 10:31
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseService
{
    /**
     * 获取所有数据表的状态
     *
     * @return array|mixed
     * Author: Stephen
     * Date: 2020/7/28 10:20:58
     */
    public function getTableStatus()
    {
        $data = DB::select('SHOW TABLE STATUS');
        $data = json_decode(json_encode($data),true);
        $data = array_map('array_change_key_case', $data);

        return $data;
    }

    /**
     * 获取数据表的所有字段
     *
     * @param $tableName
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 10:21:26
     */
    public function getFullColumnsFromTable($tableName)
    {
        $field_list = DB::select('SHOW FULL COLUMNS FROM `' . $tableName . '`');
        $field_list = json_decode(json_encode($field_list),true);

        $data = [];
        foreach ($field_list as $key => $value) {
            $data[] = [
                'name'       => $value['Field'],
                'type'       => $value['Type'],
                'collation'  => $value['Collation'],
                'null'       => $value['Null'],
                'key'        => $value['Key'],
                'default'    => $value['Default'],
                'extra'      => $value['Extra'],
                'privileges' => $value['Privileges'],
                'comment'    => $value['Comment'],
            ];
        }

        return $data;
    }

    /**
     * 优化数据表
     *
     * @param $tableName
     * Author: Stephen
     * Date: 2020/7/28 10:21:56
     */
    public function optimizeTable($tableName)
    {
        $result = DB::select("OPTIMIZE TABLE `{$tableName}`");

        if ($result)
        {
            return success("数据表`{$tableName}`优化成功");
        }

        return error("数据表`{$tableName}`优化失败");
    }

    /**
     * 修复数据表
     *
     * @param $tableName
     * Author: Stephen
     * Date: 2020/7/28 10:22:16
     */
    public function repairTable($tableName)
    {
        $result = DB::select("REPAIR TABLE `{$tableName}`");

        if ($result)
        {
            return success("数据表`{$tableName}`修复成功");
        }

        return error("数据表`{$tableName}`修复失败");
    }

}