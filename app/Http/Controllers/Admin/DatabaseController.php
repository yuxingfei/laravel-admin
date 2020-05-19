<?php
/**
 * 数据维护
 *
 *@author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends AdminBaseController
{

    /**
     * 获取数据表
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:19
     */
    public function table()
    {
        $data = DB::select('SHOW TABLE STATUS');
        $data = json_decode(json_encode($data),true);
        $data = array_map('array_change_key_case', $data);

        return $this->admin_view('admin/database/table',[
            'data'  => $data,
            'total' => count($data),
        ]);
    }

    /**
     * 查看表信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:20
     */
    public function view(Request $request)
    {
        $name = $request->query('name');

        if (!$name) {
            return error('请指定要查看的表');
        }

        $field_list = DB::select('SHOW FULL COLUMNS FROM `' . $name . '`');
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

        return $this->admin_view('admin.database.view',['data' => $data]);
    }

    /**
     * 优化表
     *
     * @param Request $request
     * Author: Stephen
     * Date: 2020/5/18 16:20
     */
    public function optimize(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return error('请指定要优化的表');
        }
        $name   = is_array($name) ? implode('`,`', $name) : $name;
        $result = DB::select("OPTIMIZE TABLE `{$name}`");
        if ($result) {
            return success("数据表`{$name}`优化成功");
        }
        return error("数据表`{$name}`优化失败");
    }

    /**
     * 修复表
     *
     * @param Request $request
     * Author: Stephen
     * Date: 2020/5/18 16:20
     */
    public function repair(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return error('请指定要修复的表');
        }
        $name   = is_array($name) ? implode('`,`', $name) : $name;
        $result = DB::select("REPAIR TABLE `{$name}`");
        if ($result) {
            return success("数据表`{$name}`修复成功");
        }
        return error("数据表`{$name}`修复失败");
    }

}