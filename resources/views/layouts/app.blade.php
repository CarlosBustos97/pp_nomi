<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{csrf_token()}}">
    </head>
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="app">
            @include('app.vertical-menu')
        </div>
        <!-- End of Page Wrapper -->
        <main class="py-4">
            @yield('content')
        </main>
        @yield('modal')
        @include('app.js')
        @yield('js')
    </body>
</html>
