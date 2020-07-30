<!--空白页面参考模版-->
@extends('admin.public.base')

@section('content')
    @include('admin.public.content_header')
<section class="content">
    <div class="row" style="display: none;">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <a class="btn flat btn-sm btn-default BackButton">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($data_config as $key => $item)
                    <li @if(0 == $key)class="active" @endif><a href="#tab_{{$key}}" data-toggle="tab">{{$item['name']}}</a></li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($data_config as $key => $item)
                    <div class="tab-pane @if(0 == $key)active @endif" id="tab_{{$key}}">

                        <form class="form-horizontal dataForm" action="{{route('admin.setting.update')}}" method="post"
                              enctype="multipart/form-data">
                            <div class="box-body">
                                <input name="id" value="{{$item['id']}}" hidden>

                                @foreach($item['content'] as $val)
                                    {!! $val['form'] !!}
                                @endforeach

                            </div>

                            <!--表单底部-->
                            <div class="box-footer">
                                @csrf
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10 col-md-4">
                                    <div class="btn-group">
                                        <button type="submit" class="btn flat btn-info dataFormSubmit">
                                            保存
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="reset" class="btn flat btn-default dataFormReset">
                                            重置
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $.each($('.dataForm'), function (index, item) {
        $(item).validate({});
    })
</script>

@endsection