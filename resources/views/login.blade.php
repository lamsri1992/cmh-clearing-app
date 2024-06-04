<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argon/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>PROD : ระบบริหารข้อมูลหนี้ระหว่างโรงพยาบาล สาธารณสุขจังหวัดเชียงใหม่</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{ secure_asset('argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ secure_asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/f97e59eabd.js" crossorigin="anonymous"></script>
    <link href="{{ secure_asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ secure_asset('argon/assets/css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet" />
</head>

<body>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-center">
                                    <h4 class="font-weight-bolder">กรุณาลงชื่อเพื่อเข้าใช้งานระบบ</h4>
                                    <p class="mb-0">
                                </div>
                                <div class="card-body">
                                    <form action="#" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="รหัสสถานบริการ" aria-label="รหัสสถานบริการ"
                                            id="username" name="username" value="{{ old('username') }}">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg" placeholder="รหัสผ่าน" aria-label="รหัสผ่าน"
                                            id="password" name="password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-success btn-lg w-100 mt-4 mb-0">
                                                <i class="fa-solid fa-right-to-bracket"></i>
                                                เข้าใช้งานระบบ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-light h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden">
                                <div class="text-center">
                                    <img src="{{ secure_asset('img/logo.png') }}" alt="สำนักงานสาธารณสุข จังหวัดเชียงใหม่" width="60%">
                                </div>
                                <h4 class="mt-5 font-weight-bolder position-relative">
                                    ระบบริหารข้อมูลหนี้ระหว่างโรงพยาบาล
                                </h4>
                                <p class="text-sm position-relative">
                                    CHIMS - Clearing House Information Management System
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ secure_asset('argon/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ secure_asset('argon/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ secure_asset('argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ secure_asset('argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ secure_asset('argon/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>
</body>

</html>
