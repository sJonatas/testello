<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
    <link rel="stylesheet" href="{{asset('/assets/css/styles.min.css')}}" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
@include('sweetalert::alert')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">

        </div>

        <div class="d-lg-flex align-items-center gap-2">
            <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center">Testello APP - Docteka</h3>
            <div class="d-flex align-items-center justify-content-center gap-2">

            </div>
        </div>

    </div>

    <x-sidemenu/>

    <div class="body-wrapper-inner" style="margin-top: 80px; margin-left: 320px">
        <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{$pageTitle ?? ''}}</h4>
                                    <p class="card-subtitle">
                                        {{$subtitle ?? ''}}
                                    </p>

                                    {{ $slot }}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
<script src="{{asset('/assets/js/app.min.js')}}"></script>
<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
