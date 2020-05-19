<?php
/**
 * 市-省市区
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Libs\Generate\Field;

class City extends Field
{

    public static $html = <<<EOF
<div class="form-group">
    <label for="[FIELD_NAME]" class="col-sm-2 control-label">[FORM_NAME]</label>
    <div class="col-sm-10 col-md-4">
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-list"></i></span>
            <select name="[FIELD_NAME]" id="[FIELD_NAME]" class="form-control field-city"  onchange="getRegion(this.value,2)">
                @foreach(\$city as \$item)
                 <option value="{{\$item['id']}}" @if(\$item['id'] == \$info['[FIELD_NAME]'])selected @endif>{{\$item['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<script>
 $('#[FIELD_NAME]').select2();
 
</script>\n
EOF;

    public static $rules = [
        'required'   => '非空',
        'regular'    => '自定义正则'
    ];


    public static function create($data)
    {
        $html = self::$html;
        $html = str_replace('[FORM_NAME]', $data['form_name'], $html);
        $html = str_replace('[FIELD_NAME]', $data['field_name'], $html);
        return $html;
    }
}