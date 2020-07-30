<?php

/**
 * 全局公用函数
 *
 * @author yuxingfei<474949931@qq.com>
 */

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Model\Admin\AdminMenu;

/**
 * 不做任何操作
 */
const URL_CURRENT = 'url://current';

/**
 * 刷新页面
 */
const URL_RELOAD = 'url://reload';

/**
 * 返回上一个页面
 */
const URL_BACK = 'url://back';

/**
 * 关闭当前layer弹窗
 */
const URL_CLOSE_LAYER = 'url://close-layer';

/**
 * 关闭当前弹窗并刷新父级
 */
const URL_CLOSE_REFRESH = 'url://close-refresh';

/**
 * 登录用户key
 */
const LOGIN_USER = 'loginUser';

/**
 * 登录用户id
 */
const LOGIN_USER_ID = 'LoginUserId';

/**
 * 登录用户签名
 */
const LOGIN_USER_ID_SIGN = 'loginUserIdSign';

if (!function_exists('debugArr')) {
    /**
     * 简单调试使用 print_r
     *
     * @param $var
     * Author: Stephen
     * Date: 2020/4/28 16:57
     */
    function debugArr($var)
    {
        echo "<pre>";
        print_r($var);
        exit;
    }
}

if (!function_exists('debugVarDump')) {
    /**
     * 简单调试使用 var_dump
     *
     * @param $var
     * Author: Stephen
     * Date: 2020/5/18 15:56
     */
    function debugVarDump($var)
    {
        echo "<pre>";
        var_dump($var);
        exit;
    }
}

if (!function_exists('success')) {

    /**
     * 成功返回辅助方法
     *
     * @param string $msg    提示信息
     * @param string $url    跳转地址
     * @param string $data   返回数据
     * @param int $wait      跳转等待时间
     * @param array $header  header携带参数
     * Author: Stephen
     * Date: 2020/5/18 15:57
     */
    function success($msg = '操作成功', $url = URL_BACK, $data = '', $wait = 0, array $header = [])
    {
        result(1, $msg, $data, $url, $wait, $header);
    }
}

if (!function_exists('error')) {
    /**
     * 错误返回辅助方法
     *
     * @param string $msg     提示信息
     * @param string $url     跳转地址
     * @param string $data    返回数据
     * @param int $wait       跳转等待时间
     * @param array $header   header携带参数
     * Author: Stephen
     * Date: 2020/5/18 15:59
     */
    function error($msg = '操作失败', $url = URL_CURRENT, $data = '', $wait = 0, array $header = [])
    {
        result(0, $msg, $data, $url, $wait, $header);
    }
}

if (!function_exists('result')) {
    /**
     * 返回结果辅助方法
     *
     * @param int $code     返回码
     * @param string $msg   提示信息
     * @param string $data  返回数据
     * @param null $url     跳转地址
     * @param int $wait     跳转等待时间
     * @param array $header header携带参数
     * Author: Stephen
     * Date: 2020/5/18 15:59
     */
    function result($code = 0, $msg = 'unknown', $data = '', $url = null, $wait = 3, array $header = [])
    {
        if (request()->isMethod('post')) {

            $url      = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : route($url);

            $result   = [
                'code' => $code,
                'msg'  => $msg,
                'data' => $data,
                'url'  => $url,
                'wait' => $wait,
            ];

            throw new HttpResponseException(response()->json($result)->withHeaders($header));
        }

        if ($url === null) {
            $url = request()->server('HTTP_REFERER') ?? 'admin.index.index';
        }

        $data = empty($data) ? [] : $data;

        throw new HttpResponseException(redirect()->route($url,$data)->with([$code ? 'success_message' : 'error_message' => $msg, 'url' => route($url)]));

    }
}

if (!function_exists('exception')) {
    /**
     * 抛出异常处理
     *
     * @param $msg               异常消息
     * @param int $code          异常代码 默认为0
     * @param string $exception  异常类
     * Author: Stephen
     * Date: 2020/5/18 16:00
     */
    function exception($msg, $code = 0, $exception = '')
    {
        $e = $exception ?: '\Exception';
        throw new $e($msg, $code);
    }
}

if (!function_exists('format_size')) {
    /**
     * 格式化文件大小单位
     *
     * @param $size
     * @param string $delimiter
     * @return string
     * Author: Stephen
     * Date: 2020/5/18 16:01
     */
    function format_size($size, $delimiter = '')
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . $delimiter . $units[$i];
    }
}

if (!function_exists('parse_name')) {
    /**
     * 字符串命名风格转换
     *
     * @param $name         字符串
     * @param int $type     转换类型
     * @param bool $ucfirst 首字母是否大写（驼峰规则）
     * @return string       返回字符串
     * Author: Stephen
     * Date: 2020/5/18 16:02
     */
    function parse_name($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);

            return $ucfirst ? ucfirst($name) : lcfirst($name);
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }
}

if (!function_exists('create_setting_file')) {
    /**
     * 生成配置文件
     *
     * @param $data    SettingGroup
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 16:04
     */
    function create_setting_file($data)
    {
        $result = true;
        if ($data->auto_create_file == 1) {
            $file = $data->code . '.php';
            if ($data->module !== 'app') {
                $file = strtolower($data->module) . '/' . $data->code . '.php';
            }

            $setting   = $data->setting;
            $path      = config_path().'/'. $file;
            $file_code = "<?php\r\n\r\n/**\r\n* " .
                $data->name . ':' . $data->description .
                "\r\n* 此配置文件为自动生成，生成时间" . date('Y-m-d H:i:s') .
                "\r\n* @author yuxingfei<474949931@qq.com>" .
                "\r\n*/\r\n\r\nreturn [";
            foreach ($setting as $key => $value) {
                $file_code .= "\r\n    //" . $value['name'] . ':' . $value['description'] . "\r\n    '" . $value['code'] . "'=>[";
                foreach ($value->content as $content) {
                    $file_code .= "\r\n    //" . $content['name'] . "\r\n    '" .
                        $content['field'] . "'=>'" . $content['content'] . "',";
                }
                $file_code .= "\r\n],";
            }
            $file_code .= "\r\n];";
            $result    = file_put_contents($path, $file_code);
        }
        return $result ? true : false;
    }
}


if (!function_exists('create_setting_menu')) {
    /**
     * 生成配置文件
     *
     * @param $data SettingGroup
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:04
     */
    function create_setting_menu($data)
    {

        $function = <<<EOF
            public function [GROUP_COED]()
            {
                return \$this->show([GROUP_ID]);
            }\n
        }//append_menu
EOF;

        $result = true;
        if ($data->auto_create_menu == 1) {
            $url  = 'admin/setting/' . $data->code;
            $menu = AdminMenu::where('url', $url)->first();
            if (!$menu) {
                $result = AdminMenu::create([
                    'parent_id' => 43,
                    'name'      => $data->name,
                    'icon'      => $data->icon,
                    'is_show'   => 1,
                    'url'       => $url
                ]);
            } else {
                $menu->name = $data->name;
                $menu->icon = $data->icon;
                $menu->url  = $url;
                $result     = $menu->save();
            }

            $setting = app()->make(\App\Http\Controllers\Admin\SettingController::class);

            if (!method_exists($setting, $data->code)) {

                $function = str_replace(array('[GROUP_COED]', '[GROUP_ID]'), array($data->code, $data->id), $function);

                $file_path = app_path() . '/Http/Controllers/Admin/SettingController.php';
                $file      = file_get_contents($file_path);
                $file      = str_replace('}//append_menu', $function, $file);
                file_put_contents($file_path, $file);
            }
        }

        return $result ? true : false;
    }
}