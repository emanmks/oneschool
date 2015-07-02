<!DOCTYPE html>
<html lang="en">
   
    <head>
    <meta charset="utf-8">
    <title>Creative - OneSchool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student & Academic Information System for OneSchool">
    <meta name="author" content="ewakooLabs">
    
    <!-- Main Style CSS - Include with every page -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/font-awesome.min.css') }}
    {{ HTML::style('assets/css/ionicons.css') }}

    <!-- Admin LTE CSS - Include with every page -->
    {{ HTML::style('assets/css/AdminLTE.css') }}


    <!-- Core Scripts - Include with every page -->
    {{ HTML::script('assets/js/jquery-2.1.0.min.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/AdminLTE/app.js') }}

    {{ HTML::style('assets/img/logo.png', array('rel' => 'shortcut icon')) }}
    {{ HTML::style('assets/img/logo.png', array('rel' => 'icon')) }}
    
    </head>

    <body class="skin-blue">

        <header class="header">
            @include('templates/navigation')
        </header>
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                @include('templates/sidebar')
            </aside>

            <aside class="right-side ">
                @yield('content')
            </aside>
        </div>

    </body>
</html>    