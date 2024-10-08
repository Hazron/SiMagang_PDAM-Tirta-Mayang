<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SiMagang Tirta Mayang</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets_landing/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets_landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">



    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets_landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets_landing/css/style.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex flex-column justify-content-center align-items-center">
        <div class="container text-center text-md-left">
            <h1><span>SiMagang Tirta Mayang</span></h1>
            <h2>Aplikasi Presensi, Logbook untuk Peserta Magang di PDAM Tirta Mayang</h2>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-get-started scrollto me-3">DASHBOARD</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-get-started scrollto">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-get-started scrollto">LOGIN</a>
            @endauth
        </div>
    </section><!-- End Hero -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets_landing/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets_landing/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets_landing/js/main.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


</body>

</html>
