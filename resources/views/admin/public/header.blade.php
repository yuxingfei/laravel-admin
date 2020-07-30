<!--网页头部-->
@if(!$admin['pjax'])
<header class="main-header">
    <a class="logo">
        <span class="logo-mini">{{isset($admin['short_name']) ? $admin['short_name'] : 'Backend'}}</span>
        <span class="logo-lg">{{isset($admin['name']) ? $admin['name'] : 'Backend'}}</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle ReloadButton" title="刷新页面" data-toggle="dropdown">
                        <i class="fa fa-refresh"></i>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{isset($admin['user']['avatar']) ? $admin['user']['avatar'] : asset('/static/admin/images/avatar.png')}}" onerror="javascript:this.src='{{asset('/static/admin/images/avatar.png')}}';this.onerror = null" class="user-image" alt="用户头像">
                        <span class="hidden-xs">{{isset($admin['user']['nickname']) ? $admin['user']['nickname'] : ''}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{isset($admin['user']['avatar']) ? $admin['user']['avatar'] : asset('/static/admin/images/avatar.png')}}" onerror="javascript:this.src='{{asset('/static/admin/images/avatar.png')}}';this.onerror = null" class="img-circle" alt="用户头像">
                            <p>
                                {{isset($admin['user']['nickname']) ? $admin['user']['nickname'] : ''}}
                                <small>{{isset($admin['user']['username']) ? $admin['user']['username'] : ''}}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('admin.admin_user.profile')}}" class="btn btn-default btn-flat">个人资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('admin.auth.logout')}}" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
@endif
