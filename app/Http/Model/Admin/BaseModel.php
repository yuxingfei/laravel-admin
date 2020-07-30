<?php

/**
 * Admin模块BaseModel基础模型
 *
 * @author yuxingfei<474949931@qq.com>
 */
namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    //可搜索字段
    protected $searchField = [];

    //可作为条件的字段
    protected $whereField = [];

    //可做为时间范围查询的字段
    protected $timeField = [];

    //禁止删除的数据id
    public $noDeletionId = [];

    /**
     * 查询处理
     *
     * @param $query
     * @param $param
     * Author: Stephen
     * Date: 2020/5/18 16:54
     */
    public function scopeAddWhere($query, $param): void
    {
        //关键词like搜索
        $keywords = $param['_keywords'] ?? '';

        if (!empty($keywords) && count($this->searchField) > 0) {
            array_walk($this->searchField,function (&$val){
                $val = '`'.$val.'`';
                return true;
            });
            $this->searchField = implode(',', $this->searchField);
            $query->whereRaw("concat(".$this->searchField.") like '%".$keywords."%'");
        }

        //字段条件查询
        if (count($this->whereField) > 0 && count($param) > 0) {
            foreach ($param as $key => $value) {
                if (!empty($value) && in_array((string)$key, $this->whereField, true)) {
                    $query->where($key, $value);
                }
            }
        }

        //时间范围查询
        if (count($this->timeField) > 0 && count($param) > 0) {
            foreach ($param as $key => $value) {
                if (!empty($value) && in_array((string)$key, $this->timeField, true)) {
                    $time_range = explode(' - ', $value);
                    [$start_time,$end_time] = $time_range;

                    //如果是int，进行转换
                    if(false !== strtotime($start_time)){
                        $start_time = strtotime($start_time);
                        if (strlen($end_time) === 10) {
                            $end_time .= '23:59:59';
                        }
                        $end_time = strtotime($end_time);
                    }

                    $query->whereBetween($key, [$start_time, $end_time]);
                }
            }
        }

        //排序
        $order = $param['_order'] ?? '';
        $by    = $param['_by'] ?? 'desc';

        $query->orderBy($order ?: 'id', $by ?: 'desc');
    }

    public function getNoDeletionId(){
        return $this->noDeletionId;
    }

}
