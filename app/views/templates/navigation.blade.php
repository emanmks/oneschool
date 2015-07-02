<a href="{{ URL::to('/') }}" class="logo">Creative</a>

<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>K' {{ Auth::user()->username }} <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">
                        {{ HTML::image('assets/img/avatar5.png', 'User Avatar', array('class' => 'img-circle')) }}
                        <p>
                            {{ Auth::user()->username }}
                            <small>{{ Auth::user()->role }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="col-xs-6">
                            <span class="label label-success"><!----></span>
                        </div>
                        <div class="col-xs-6">
                            <span class="label label-success"><!----></span>
                        </div>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-right">
                            <a href="{{ URL::to('logout') }}" class="btn btn-danger"><i class="fa fa-power-off"></i> Keluar</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>