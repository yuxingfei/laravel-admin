<?php
/**
 * 列表多项选择
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Libs\Generate\Field;

class MultiSelect extends Field
{
    public static $html = <<<EOF
<div class="form-group">
    <label for="[FIELD_NAME]" class="col-sm-2 control-label">[FORM_NAME]</label>
    <div class="col-sm-10 col-md-4">
       
        <select name="[FIELD_NAME][]" id="[FIELD_NAME]" data-placeholder="请选择[FORM_NAME]" class="form-control field-multi-select" multiple="multiple">
            <option value=""></option>
        </select>
    </div>
</div>
<script>
 $('#[FIELD_NAME]').select2();
</script>\n
EOF;

    public static $rules = [
        'required' => '非空',
        'regular'  => '自定义正则'
    ];


    public static function create($data)
    {
        $html = self::$html;
        $html = str_replace('[FORM_NAME]', $data['form_name'], $html);
        $html = str_replace('[FIELD_NAME]', $data['field_name'], $html);
        return $html;
    }
}