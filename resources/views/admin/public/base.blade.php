@if(!$admin['pjax'])
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="renderer" content="webkit">
@endif

    @section('title')
        <title>{{isset($admin['title']) ? $admin['title'] : 'Admin'}} | {{isset($admin['name']) ? $admin['name'] : 'Admin'}}</title>
    @show


@if(!$admin['pjax'])
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('admin.public.head_css')

    @include('admin.public.head_js')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@endif

    <!-- 顶部 -->
    @section('header')
        @include('admin.public.header')
    @show
    <!-- 左侧 -->
    @section('sidebar')
        @include('admin.public.sidebar')
    @show
    <!-- 内容 -->
    <div class="content-wrapper" id="pjax-container">
        @yield('content')
    </div>
    @section('footer')
        @include('admin.public.footer')
    @show

    @section('control_sidebar')
        @include('admin.public.control_sidebar')
    @show

@if(!$admin['pjax'])
</div>
@endif

@if(!$admin['pjax'])
</body>
</html>
@endif