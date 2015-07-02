<!DOCTYPE html>
<html class="bg-black">

<head>

    <title>Creative - OneSchool | Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Student & Academic Information System for OneSchool">
    <meta name="author" content="Unggul Visi Utama">

    <!-- Core CSS - Include with every page -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}

    <!-- Admin LTE CSS - Include with every page -->
    {{ HTML::style('assets/css/AdminLTE.css') }}

    {{ HTML::style('assets/img/logo.png', array('rel' => 'shortcut icon')) }}
    {{ HTML::style('assets/ico/favicon.ico', array('rel' => 'icon')) }}

</head>

<body class="bg-black">

    @yield('content')

</body>

</html>
