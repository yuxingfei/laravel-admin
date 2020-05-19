@if(!$admin['pjax'])
@include('admin.public.head_css')
@include('admin.public.head_js')
@endif
<!-- 内容 -->
<div id="pjax-container">
    @yield('content')
</div>

