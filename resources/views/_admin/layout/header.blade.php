   <header class="main-header">
        <!-- Logo -->
        <a href="/admin" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ substr(get_buzzy_config('sitename'),0,1) }}</b>P</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ get_buzzy_config('sitename') }}</b>{{ trans('admin.panel') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <!-- Sidebar toggle button-->

                <a href="{{ url('/') }}" target="_blank"  style="margin-top:10px;color:#fff!important;" class="btn btn-sm btn-success pull-left"><i class="fa fa-eye"></i>  {{ trans('admin.viewsite') }}</a>
                <ul class="nav navbar-nav">

                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                            <span class="label label-success">{{ $toplamapprove }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">{{ $toplamapprove }} {{ trans('admin.waitingapprove') }}</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                @foreach($waitapprove as $qas)
                                    <li><!-- start message -->
                                        <a href="{{ generate_post_url($qas) }}" target="_blank">
                                            <div class="pull-left">
                                                <img src="{{ makepreview($qas->thumb, 's', 'posts') }}" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                {{ $qas->title }}
                                            </h4>
                                            <p><i class="fa fa-clock-o"></i> {{ $qas->created_at->diffForHumans() }}</p>
                                        </a>
                                    </li><!-- end message -->
                                 @endforeach
                                </ul>
                            </li>
                            <li class="footer"><a href="/admin/unapprove?only=unapprove">{{ trans('admin.viewall') }}</a></li>
                        </ul>
                    </li>

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{  Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ makepreview(Auth::user()->icon, 's', 'members/avatar') }}" class="img-circle" alt="User Image">
                                <p>
                                    {{  Auth::user()->username }} - Admin
                                    <small>{{ trans('admin.Membersince') }} {{  Auth::user()->created_at }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile/{{  Auth::user()->username_slug }}" class="btn btn-default btn-flat">{{ trans('admin.Profile') }}</a>
                                </div>
                                <div class="pull-right">
                                     <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ trans('admin.Signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>