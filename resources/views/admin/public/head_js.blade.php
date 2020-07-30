<!--头部js-->
@if(!$admin['pjax'])
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/js-cookie/js.cookie-2.2.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/jquery-ui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/laydate/laydate.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/jquery-validation/localization/messages_zh.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/bootstrap-number/bootstrap-number.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/fastclick/fastclick.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/nprogress/nprogress.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/iconpicker/js/iconpicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/fileinput/js/plugins/piexif.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/fileinput/js/fileinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/fileinput/js/locales/zh.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/ueditor/ueditor.all.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/ueditor/lang/zh-cn/zh-cn.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/clipboard/clipboard.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/viewer/viewer.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_PLUGINS__.'/viewer/jquery-viewer.min.js')}}"></script>
<!--勿必把地图api key更换成自己的-->
<!--<script type="text/javascript" src='//webapi.amap.com/maps?v=1.4.15&key=cccf8ea926e153be0a013d55edd47c11&plugin=AMap.ToolBar'></script>-->
<!-- UI组件库 1.0 -->
<!--<script src="//webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>-->
<script>
    //是否为debug模式
    var adminDebug = {{$debug}};
    //cookie前缀
    var cookiePrefix = '{{$cookiePrefix}}';
    //UEditor server地址
    var UEServer = "{{route('admin.editor.server')}}";
    //列表页当前选择的ID
    var dataSelectIds = [];
</script>
<script type="text/javascript" src="{{asset(__ADMIN_JS__.'/adminlte.min.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_JS__.'/jquery.pjax.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_JS__.'/admin.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_JS__.'/demo.js')}}"></script>
<script type="text/javascript" src="{{asset(__ADMIN_JS__.'/app.js')}}"></script>

@endif