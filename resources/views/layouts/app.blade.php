<!doctype html>
<html lang="en" data-bs-theme="blue-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="../assets/images/favicon-32x32.png" type="image/png">

    <!-- Loader -->
    <link href="../assets/css/pace.min.css" rel="stylesheet">
    <script src="../assets/js/pace.min.js"></script>

    <!-- Plugins -->
    <link href="../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="../assets/plugins/metismenu/metisMenu.min.css" rel="stylesheet">
    <link href="../assets/plugins/metismenu/mm-vertical.css" rel="stylesheet">
    <link href="../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Main CSS -->
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../sass/main.css" rel="stylesheet">
    <link href="../sass/dark-theme.css" rel="stylesheet">
    <link href="../sass/blue-theme.css" rel="stylesheet">
    <link href="../sass/semi-dark.css" rel="stylesheet">
    <link href="../sass/bordered-theme.css" rel="stylesheet">
    <link href="../sass/responsive.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="../assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navigation')

    <!-- Start Main Wrapper -->
    <main class="main-wrapper">
        <div class="main-content">
            @yield('content')
        </div>
    </main>

    <div class="overlay btn-toggle"></div>

        {{-- <button class="btn btn-grd btn-grd-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2"
            type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
            <i class="material-icons-outlined">tune</i>Customize
        </button> --}}

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
        <div class="offcanvas-header border-bottom h-70">
            <div class="">
                <h5 class="mb-0">Theme Customizer</h5>
                <p class="mb-0">Customize your theme</p>
            </div>
            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
                <i class="material-icons-outlined">close</i>
            </a>
        </div>
        <div class="offcanvas-body">
            <div>
                <p>Theme variation</p>
                <div class="row g-3">
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="BlueTheme" checked>
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BlueTheme">
                            <span class="material-icons-outlined">contactless</span>
                            <span>Blue</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="LightTheme">
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
                            <span class="material-icons-outlined">light_mode</span>
                            <span>Light</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
                            <span class="material-icons-outlined">dark_mode</span>
                            <span>Dark</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
                            <span class="material-icons-outlined">contrast</span>
                            <span>Semi Dark</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="BorderedTheme">
                        <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BorderedTheme">
                            <span class="material-icons-outlined">border_style</span>
                            <span>Bordered</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="../assets/js/jquery.min.js"></script>

    <!-- Plugins -->
    <script src="../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="../assets/plugins/metismenu/metisMenu.min.js"></script>
    <script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="../assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="../assets/plugins/peity/jquery.peity.min.js"></script>

    <!-- DataTables -->
    <script src="../assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: false,
                buttons: ['excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!-- Custom Scripts -->
    <script>
        $(".data-attributes span").peity("donut")
    </script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/dashboard1.js"></script>
    <script>
        new PerfectScrollbar(".user-list")
    </script>

</body>
</html>
