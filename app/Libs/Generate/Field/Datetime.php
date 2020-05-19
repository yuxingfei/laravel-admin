<?php
/**
 * 日期时间
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Libs\Generate\Field;

class Datetime extends Field
{
    public static $html = <<<EOF
<div class="form-group">
    <label for="[FIELD_NAME]" class="col-sm-2 control-label">[FORM_NAME]</label>
    <div class="col-sm-10 col-md-4">
        <input id="[FIELD_NAME]" readonly name="[FIELD_NAME]" value="{{isset(\$data['[FIELD_NAME]']) ? \$data['[FIELD_NAME]']: '[FIELD_DEFAULT]'}}" placeholder="请选择[FORM_NAME]" type="text" class="form-control filed-datetime">
    </div>
</div>
<script>
    laydate.render({
        elem: '#[FIELD_NAME]',
        type: 'datetime',
    });
</script>\n
EOF;

    public static $rules = [
        'required'  => '非空',
        'date_time' => '日期时间',
        'regular'   => '自定义正则'
    ];


    public static function create($data)
    {
        return str_replace(array('[FORM_NAME]', '[FIELD_NAME]', '[FIELD_DEFAULT]'), array($data['form_name'], $data['field_name'], $data['field_default']), self::$html);
    }
}