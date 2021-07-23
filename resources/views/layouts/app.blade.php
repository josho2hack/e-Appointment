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
    <meta property="og:image" content="/assets/images/og_the-revenue-department.jpg" />
    <meta property="og:title" content="กรมสรรพากร" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@revenuedept" />
    <meta name="twitter:creator" content="@revenuedept" />
    <meta name="twitter:description"
        content="กรมสรรพากร จัดเก็บภาษีทันสมัย ใส่ใจบริการ ยึดมั่นธรรมภิบาล เพื่อพัฒนาการเศรษฐกิจและสังคมไทย" />
    <meta name="twitter:image" content="/assets/images/og_the-revenue-department.jpg" />
    <meta name="twitter:title" content="กรมสรรพากร" />
    <meta name="revisit-after" content="7 days" />

    <link rel="icon" type="image/x-icon" href="/assets/images/favicon/favicon-32x32.png" />
    <link rel="shortcut type=" image/x-icon" href="/assets/images/favicon/favicon-32x32.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="css/app.css">

    <!-- Scripts -->
    <script src="js/app.js" defer></script>

    <!--- CSS --->
    <link rel="stylesheet" href="/assets/fonts/fonts.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--- Custom CSS --->
    <link rel="stylesheet" href="/assets/css/style.css">
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

        <!-- Footer Content -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-500">
                <div class="flex justify-between sm:items-center">
                    <div class="text-center text-sm text-gray-500 sm:text-left">
                        <div class="flex items-center">
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                viewBox="0 0 24 24" stroke="currentColor" class="-mt-px w-5 h-5 text-gray-400">
                                <path
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>

                            <a href="#" class="ml-1 underline">
                                {{ __('Document') }}
                            </a>

                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>

                            <a href="#" class="ml-1 underline">
                                {{ __('Chat') }}
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        e-Appointment v 1.0.0
                    </div>
                </div>
                <footer class="py-5">
                    <div class="container">
                        <div class="row">
                            <!-- Owner System -->
                            <div class="col-lg-12 text-center">
                                <h5>สอบถามรายละเอียดเพิ่มเติม</h5>
                                <p><a title="คลิกเพื่อโทรหา Call Center: 1161" href="tel:1161"> RD Intelligent
                                        Center 1161</a><br />
                                    ด้านสิทธิประโยชน์ทางภาษี : โทร. 02-2728289, 02-2728400, 02-2729168,
                                    02-2729819<br />ด้านระบบงาน : โทร. 02-272-8804, 02-272-8743</p>
                            </div>
                            <!-- Footer Address -->
                            <hr />
                            <div class="col-lg-12 text-center">
                                <h5>กรมสรรพากร</h5>
                                <p>90 ซอยพหลโยธิน 7 ถนนพหลโยธิน แขวงพญาไท เขตพญาไท กรุงเทพฯ 10400</p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    {{-- <script src="/assets/vendor/jquery/jquery.slim.min.js"></script> --}}
    {{-- <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}

</body>

</html>
