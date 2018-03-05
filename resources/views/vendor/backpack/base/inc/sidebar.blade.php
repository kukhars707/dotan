@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}"
                         class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('backpack::base.administration') }}</li>
                <!-- ================================================ -->
                <!-- ==== Recommended place for admin menu items ==== -->
                <!-- ================================================ -->
                <li><a href="{{ url(config('backpack.base.route_prefix', 'olegadmin').'/dashboard') }}"><i
                                class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a>
                </li>


                <!-- ======================================= -->
                <li class="header">{{ trans('backpack::base.user') }}</li>
                <li>
                    <a href="{{ url(config('backpack.base.route_prefix', 'olegadmin').'/logout') }}">
                        <i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(config('backpack.base.route_prefix', 'olegadmin').'/setting') }}">
                        <i class="fa fa-cog"></i> <span>Настройки сайта</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(config('backpack.base.route_prefix', 'olegadmin').'/page') }}">
                        <i class="fa fa-file-o"></i> <span>Страницы</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('olegadmin/menu-item') }}">
                        <i class="fa fa-list"></i> <span>Меню</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('olegadmin/article') }}">
                        <i class="fa fa-list"></i> <span>Статьи</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('olegadmin/images') }}">
                        <i class="fa fa-list"></i> <span>Изображения</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('olegadmin/videos') }}">
                        <i class="fa fa-list"></i> <span>Видео</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('olegadmin/manuals') }}">
                        <i class="fa fa-list"></i> <span>Гайды</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span>Категории</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ url('olegadmin/video-category') }}">
                                <i class="fa fa-list"></i> <span>Видео</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('olegadmin/image-category') }}">
                                <i class="fa fa-list"></i> <span>Изображение</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('olegadmin/article-category') }}">
                                <i class="fa fa-list"></i> <span>Статьи</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endif
