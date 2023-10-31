<!DOCTYPE html>
<html lang="en">
    @include('app.head')
    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">
            @include('app.vertical-menu')

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                @include('app.horizontal-menu')

                <!-- Main Content -->
                <div id="content">
                    @yield('content')
                </div>
                <!-- End of Main Content -->
                @component('components.js.functions')
                @endcomponent
                <!-- Footer -->
                @include('app.footer')
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        @yield('modal')
        @include('app.js')
        @yield('js')
    </body>

</html>
