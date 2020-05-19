<?php
/**
 * 基础验证器,增加验证场景(个人认为验证场景一块thinkphp做的比较好)
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Validate;

use Illuminate\Support\Facades\Validator;
/**
 * 扩展验证器
 */
class BaseValidate{

    /**
     * 当前验证规则
     * @var array
     */
    protected $rule = [];

    /**
     * 验证提示信息
     * @var array
     */
    protected $message = [];

    /**
     * 验证场景定义
     * @var array
     */
    protected $scene = [];

    /**
     * 设置当前验证场景
     * @var array
     */
    protected $currentScene = null;

    /**
     * 验证失败错误信息
     * @var array
     */
    protected $error = [];

    /**
     * 场景需要验证的规则
     * @var array
     */
    protected $only = [];

    /**
     * 自定义规则
     * @var array
     */
    protected $sometimes = [];

    /**
     * 设置验证场景
     *
     * @param $name
     * @return $this
     * Author: Stephen
     * Date: 2020/5/18 17:04
     */
    public function scene($name)
    {
        // 设置当前场景
        $this->currentScene = $name;

        return $this;
    }

    /**
     * 数据验证
     *
     * @param $data
     * @param array $rules
     * @param array $message
     * @param string $scene
     * @param array $sometimes
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 17:04
     */
    public function check($data, $rules = [], $message = [],$scene = '',$sometimes = [])
    {
        $this->error =[];

        if (empty($rules)) {
            //读取验证规则
            $rules = $this->rule;
        }
        if (empty($message)) {
            $message = $this->message;
        }

        //读取场景
        if (!$this->getScene($scene)) {
            return false;
        }

        //如果场景需要验证的规则不为空
        if (!empty($this->only)) {
            $new_rules = [];
            foreach ($this->only as $key => $value) {
                if (array_key_exists($value,$rules)) {
                    $new_rules[$value] = $rules[$value];
                }
            }
            $rules = $new_rules;
        }

        $validator = Validator::make($data,$rules,$message);

        //验证失败
        if ($validator->fails()) {
            $this->error = $validator->errors()->first();
            return false;
        }

        return !empty($this->error) ? false : true;
    }

    /**
     * 获取数据验证的场景
     *
     * @param string $scene
     * @return bool
     * Author: Stephen
     * Date: 2020/5/18 17:05
     */
    protected function getScene($scene = '')
    {
        if (empty($scene)) {
            // 读取指定场景
            $scene = $this->currentScene;
        }

        $this->only = [];

        if (empty($scene)) {
            return true;
        }

        if (!isset($this->scene[$scene])) {
            //指定场景未找到写入error
            $this->error = "scene:".$scene.'is not found';
            return false;
        }

        // 如果设置了验证适用场景
        $scene = $this->scene[$scene];
        if (is_string($scene)) {
            $scene = explode(',', $scene);
        }

        //将场景需要验证的字段填充入only
        $this->only = $scene;

        return true;
    }

    /**
     * 获取错误信息
     *
     * @return array
     * Author: Stephen
     * Date: 2020/5/18 17:05
     */
    public function getError()
    {
        return $this->error;
    }

}