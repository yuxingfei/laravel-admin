<?php
/**
 * required规则相关
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Libs\Generate\Rule;

class Required
{
    public static $ruleValidate =  <<<EOF
    '[FIELD_NAME]|[FORM_NAME]' => 'required',\n
EOF;

    public static $msgValidate =  <<<EOF
    '[FIELD_NAME].required' => '[FORM_NAME]不能为空',\n
EOF;

    public static $ruleForm =  <<<EOF
    '[FIELD_NAME]': {
        required: true,
    },\n
EOF;

    public static $msgForm =  <<<EOF
    '[FIELD_NAME]': {
        required: "[FORM_NAME]不能为空",
    },\n
EOF;

}