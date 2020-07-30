<!--内容头部-->
<section class="content-header">
    <h1>
        {!! isset($admin['title']) ? $admin['title'] : 'admin' !!}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('admin.index.index')}}"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">{!! isset($admin['title']) ? $admin['title'] : 'Admin' !!}</li>
    </ol>
</section>

@if(session('error_message'))
<!--如果有错误或者成功的消息-->
<script>
    layer.msg('{{ session("error_message") }}',{icon:2});
    $.pjax({
        url: "{{ session('url') }}",
        container: '#pjax-container'
    });
</script>
@endif

@if(session('success_message'))
<script>
    layer.msg('{{ session("success_message") }}',{icon:1});
    $.pjax({
        url: '{{ session("url") }}',
        container: '#pjax-container'
    });
</script>
@endif


