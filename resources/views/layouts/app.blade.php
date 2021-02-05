<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="keywords"
        content="กรมสรรพากร,ภาษี,ภาษีเงินได้,ภาษีเงินได้บุคคลธรรมดา,ภาษีหัก ณ ที่จ่าย,ภาษีเงินได้นิติบุคคล,ภาษีธุรกิจเฉพาะ,ยื่นแบบผ่านอินเทอร์เน็ต, ภาษีมูลค่าเพิ่ม,ขอคืนภาษี" />
    <meta name="description"
        content="กรมสรรพากร จัดเก็บภาษีทันสมัย ใส่ใจบริการ ยึดมั่นธรรมภิบาล เพื่อพัฒนาการเศรษฐกิจและสังคมไทย" />
    <meta name="robots" content="index,follow" />
    <meta name="author" content="กรมสรรพากร" />
    <meta property="og:description"
        content="กรมสรรพากร จัดเก็บภาษีทันสมัย ใส่ใจบริการ ยึดมั่นธรรมภิบาล เพื่อพัฒนาการเศรษฐกิจและสังคมไทย" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="กรมสรรพากร" />
    <meta property="og:image" content="assets/images/og_the-revenue-department.jpg" />
    <meta property="og:title" content="กรมสรรพากร" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@revenuedept" />
    <meta name="twitter:creator" content="@revenuedept" />
    <meta name="twitter:description"
        content="กรมสรรพากร จัดเก็บภาษีทันสมัย ใส่ใจบริการ ยึดมั่นธรรมภิบาล เพื่อพัฒนาการเศรษฐกิจและสังคมไทย" />
    <meta name="twitter:image" content="assets/images/og_the-revenue-department.jpg" />
    <meta name="twitter:title" content="กรมสรรพากร" />
    <meta name="revisit-after" content="7 days" />

    <link rel="icon" type="image/x-icon" href="assets/images/favicon/favicon-32x32.png" />
    <link rel="shortcut type=" image/x-icon" href="assets/images/favicon/favicon-32x32.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!--- CSS --->
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--- Custom CSS --->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.slim.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
