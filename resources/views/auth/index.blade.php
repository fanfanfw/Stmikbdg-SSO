<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="STMIK Bandung">
    <title>STMIK Bandung - Login</title>

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

    {{-- Loading Overlay --}}
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }

        #forgotPasswordText {
            cursor: pointer;
        }
    </style>
</head>
    <body class="d-flex align-items-center py-4 bg-body-tertiary">
        <main class="form-signin w-100 m-auto">

            <div class="mb-3 d-flex justify-content-center">
                <img
                    class="mb-2"
                    src="/images/stmikbdg_logo.png"
                    alt="STMIK Bandung Logo"
                    width="200"
                >
            </div>

            <form action="/authenticate" method="post" id="formLogin">
                @csrf
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" autocomplete="off" value="{{ old('email') }}" required>
                    <label for="email">Email</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <button class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-1" type="submit">
                    <i data-feather="log-in" style="width: 1.1em;"></i>
                    Login
                </button>

                {{-- Dimatikan dulu, karena outgoing email dari API tidak berjalan --}}
                <div class="mt-2">
                    <span id="forgotPasswordText" class="small text-primary">
                        Lupa password?
                    </span>
                </div>
            </form>
        </main>

        {{-- Bootstrap Modal --}}
        <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="modalForgotPassword">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Lupa Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" id="formForgotPassword">
                        @csrf
                        <div class="modal-body">
                            <label for="verifyEmail" class="form-label">Email</label>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" id="verifyEmail" name="email" required>
                                <button class="btn btn-outline-dark" title="Kirim OTP" id="buttonVerifyEmail" type="button">
                                    <i data-feather="send" class="font-monospace" style="width: 1.1em;" id="sendIcon"></i>
                                    <div class="spinner-border text-primary spinner-border-sm d-none"></div>
                                </button>
                            </div>
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Password baru</label>
                                <input type="password" class="form-control" id="newPassword" name="new_password" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Konfirmasi password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required disabled>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="buttonResetPassword">
                                <span id="buttonResetPasswordText">Simpan</span>
                                <div class="spinner-border text-light spinner-border-sm d-none"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Feather Icons --}}
        <script>
            feather.replace()
        </script>

        <script>
            $(document).ready(() => {
                $('#formLogin').submit((e) => {
                    e.preventDefault();

                    const url = new URL(window.location.href);
                    const siteParam = url.searchParams.get('site');

                    if (!siteParam) {
                        alert('Missing "site" query parameter');
                        return;
                    }

                    const siteDst = new URL(siteParam).href;

                    $.ajax({
                        url: '/authenticate',
                        type: 'POST',
                        data: {
                            _token: $('input[name="_token"]').val(),
                            email: $('#email').val(),
                            password: $('#password').val(),
                        },
                        beforeSend: () => {
                            $.LoadingOverlay('show');
                        },
                        success: (response, status, xhr) => {
                            const roles = response.data.roles;
                            const rolesLength = Object.keys(roles).length;

                            if (xhr.status === 201 && rolesLength > 1) {
                                window.location = `/verify?site=${encodeURIComponent(siteDst)}`;
                            } else if (xhr.status === 201 && rolesLength === 1) {
                                const rolesKey = Object.keys(roles)[0];
                                window.location = `/verify?site=${encodeURIComponent(siteDst)}&role=${encodeURIComponent(rolesKey)}`;
                            }
                        },
                        error: (xhr, status) => {
                            $.LoadingOverlay('hide');
                            const { responseJSON: { message } = {} } = xhr;

                            if (xhr.status === 401 || xhr.status === 429) {
                                Swal.fire({
                                    icon: xhr.status === 401 ? 'error' : 'warning',
                                    html: message || 'An error occurred',
                                    toast: true,
                                    timer: 5000,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                });
                            } else {
                                console.log(xhr);
                            }
                        }
                    });
                });

                // show modal forgot password
                $('#forgotPassword').on('click', (e) => {
                    e.preventDefault();
                    $('#formForgotPassword #verifyEmail').val('');
                    $('#otp, #newPassword, #confirmPassword').prop('disabled', true).val('');
                    $('#modalForgotPassword').modal('show');
                }); 

                // show modal forgot password for send email
                $('#forgotPasswordText').on('click', (e) => {
                    e.preventDefault();
                    $('#formForgotPassword #verifyEmail').val('');
                    $('#otp, #newPassword, #confirmPassword').prop('disabled', true).val('');
                    $('#modalForgotPassword').modal('show');
                });

                // when user press enter on field email
                $('#verifyEmail').on('keypress', (e) => {
                    if (e.which == 13) {
                        $('#buttonVerifyEmail').trigger('click');
                        e.preventDefault();
                    }
                })

                $('#buttonVerifyEmail').on('click', (e) => {
                    e.preventDefault();

                    $.ajax({
                        url: '/forgot-password/request-otp',
                        type: 'POST',
                        data: {
                            _token: $('#formForgotPassword input[name="_token"]').val(),
                            email: $('#formForgotPassword #verifyEmail').val(),
                        },
                        beforeSend: () => {
                            $('#formForgotPassword #buttonVerifyEmail #sendIcon').addClass('d-none');
                            $('#formForgotPassword #buttonVerifyEmail .spinner-border').removeClass('d-none');
                        },
                        success: (response, status, xhr) => {
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                toast: true,
                                timer: 5000,
                                timerProgressBar: true,
                                position: 'top-right',
                                showConfirmButton: false,
                            });

                            $('#otp, #newPassword, #confirmPassword').prop('disabled', false);
                        },
                        error: (xhr, status) => {
                            if (xhr.status == 400) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: xhr.responseJSON.message,
                                    toast: true,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                });
                            } else if (xhr.status == 422) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: 'Nilai email tidak boleh kosong dan harus merupakan email yang valid',
                                    toast: true,
                                    timer: 5000,
                                    timerProgressBar: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                });
                            } else {
                                $('#otp, #newPassword, #confirmPassword').prop('disabled', false);
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Informasi',
                                    text: 'Kode OTP berhasil dibuat. Namun, jika Anda tidak menerima email berisi kode OTP dari kami, mohon segera hubungi IT Support.',
                                    // toast: true,
                                    // timer: 15000,
                                    // timerProgressBar: true,
                                    // position: 'top-right',
                                    // showConfirmButton: false,
                                });
                            }
                        },
                        complete: () => {
                            $('#formForgotPassword #buttonVerifyEmail .spinner-border').addClass('d-none');
                            $('#formForgotPassword #buttonVerifyEmail #sendIcon').removeClass('d-none');
                        }
                    });
                });

                $('#formForgotPassword').on('submit', (e) => {
                    e.preventDefault();

                    const formData = {
                        otp: $('#formForgotPassword #otp').val(),
                        new_password: $('#formForgotPassword #newPassword').val(),
                        confirm_password: $('#formForgotPassword #confirmPassword').val(),
                    };

                    if (
                        formData.otp.length < 6
                        || formData.new_password.length < 8
                        || formData.confirm_password.length < 8
                    ) {
                        return Swal.fire({
                            icon: 'warning',
                            html: 'Pastikan semua field telah terisi dengan benar',
                            toast: true,
                            timer: 2000,
                            timerProgressBar: true,
                            position: 'top-right',
                            showConfirmButton: false,
                        });
                    }

                    $.ajax({
                        url: '/forgot-password/reset',
                        type: 'POST',
                        data: {
                            _token: $('#formForgotPassword input[name="_token"]').val(),
                            email: $('#formForgotPassword #verifyEmail').val(),
                            ...formData,
                        },
                        beforeSend: () => {
                            $('#formForgotPassword #buttonResetPassword #buttonResetPasswordText').addClass('d-none');
                            $('#formForgotPassword #buttonResetPassword .spinner-border').removeClass('d-none');
                        },
                        success: (response, status, xhr) => {
                            Swal.fire({
                                icon: 'success',
                                html: response.message,
                                toast: true,
                                timer: 3000,
                                timerProgressBar: true,
                                position: 'top-right',
                                showConfirmButton: false,
                            });

                            $('#modalForgotPassword').modal('hide');
                        },
                        error: (xhr, status) => {
                            console.log(xhr);

                            if (xhr.status == 400) {
                                Swal.fire({
                                    icon: 'warning',
                                    html: xhr.responseJSON.message,
                                    toast: true,
                                    timer: 1500,
                                    timerProgressBar: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                });
                            } else if (xhr.status == 422) {
                                const { errors } = xhr.responseJSON;

                                $.each(errors, (key, value) => {
                                    if (key === 'new_password' || key === 'confirm_password') {
                                        Swal.fire({
                                            icon: 'warning',
                                            html: 'Nilai password dan konfirmasi password harus sama dan tidak boleh kosong',
                                            toast: true,
                                            timer: 5000,
                                            timerProgressBar: true,
                                            position: 'top-right',
                                            showConfirmButton: false,
                                        });
                                    }
                                });
                            }
                        },
                        complete: () => {
                            $('#formForgotPassword #buttonResetPassword #buttonResetPasswordText').removeClass('d-none');
                            $('#formForgotPassword #buttonResetPassword .spinner-border').addClass('d-none');
                        }
                    });
                })
            });
        </script>
    </body>
</html>
