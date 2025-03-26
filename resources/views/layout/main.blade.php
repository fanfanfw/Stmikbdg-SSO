<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="STMIK Bandung">
    <title>STMIK Bandung - Web Authentications</title>

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.login.css">

    {{-- Feather Icons --}}
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    {{-- JQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #selectRole {
            margin-top: -150px;
        }

        .card-role {
            cursor: pointer;
            box-shadow: 0 4px;
        }

        .card-role:hover {
            transform: translateY(-5px);
            transition: 0.3s ease-in-out;
        }

        .card-role .image-wrapper {
            height: 225px;
        }

        .card-role img {
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>
    <body>
        <header>
            @include('layout.navbar')
            @include('layout.hero', [
                'message' => $message
            ])
        </header>

        <main>
            @yield('content')

            <input type="hidden" name="site_destination" value="{{ isset($site) ? $site['url'] : '' }}">
        </main>

        <footer class="d-flex justify-content-center p-3 mt-5">
            <span class="fw-bold">&copy; {{ date('Y') }}. STMIK Bandung</span>
        </footer>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Feather Icons --}}
        <script>
            feather.replace()
        </script>

        <script>
            $(document).ready(() => {
                $('#buttonLogout').click((e) => {
                    e.preventDefault();

                    const siteDst = $('input[name="site_destination"]').val();

                    window.location.href = `logout?site=${siteDst}`;
                })
            });
        </script>
    </body>
</html>
