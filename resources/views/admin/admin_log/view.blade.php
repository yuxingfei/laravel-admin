<!--空白弹出页面参考模版-->
@extends('admin.public.layer_base')
@section('content')
<!-- 这里写内容即可 -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th colspan="4" class="text-bold text-center">日志摘要</th>
                    </tr>
                    <tr>
                        <td class="text-bold">日志ID</td>
                        <td>{{$data['id']}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">操作用户</td>
                        <td>{{isset($data['adminUser']['nickname']) ? $data['adminUser']['nickname'] : '已删除'}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">操作</td>
                        <td>{{$data['name']}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">url</td>
                        <td>{{$data['url']}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">类型</td>
                        <td>{{$data['log_method']}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">ip</td>
                        <td>{{$data['log_ip']}}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">日期</td>
                        <td>{{$data['create_time']}}</td>
                    </tr>
                    <tr style="border-top:2px solid #d2d6de;">
                        <th colspan="2" class="text-bold text-center">数据详情</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <pre>{{isset($data['adminLogData']['data']) ? $data['adminLogData']['data'] : ''}}</pre>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection