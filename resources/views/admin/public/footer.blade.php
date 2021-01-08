<!--页面底部-->
@if(!$admin['pjax'])
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> {{ isset($admin['version']) ? $admin['version'] : '1.0' }}
    </div>
    <strong>Copyright &copy; @php echo date('Y'); @endphp <a href="{{ isset($admin['link']) ? $admin['link'] : '#' }}">{{ isset($admin['author']) ? $admin['author'] : 'admin' }}</a>.</strong> All rights
    reserved.
</footer>
@endif