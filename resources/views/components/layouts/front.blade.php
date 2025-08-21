<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    @include('components.layouts.style')
    @include('components.layouts.script')
</head>

<body class="layout-top-nav" style="height: auto;">
    <div class="wrapper">

        <!-- Navbar -->
        <x-layouts.front.navbar/>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 440px;">
            <!-- Content Header (Page header) -->
            <x-layouts.front.content-header/>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    {{ $slot }}
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->



        <x-layouts.footer/>
    </div>
    <!-- ./wrapper -->



</body>

</html>
