<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Learning Satpol PP | Verifikasi OTP</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .bg {
            background-image: url('{{ asset('assets/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: fixed;
            inset: 0;
            z-index: -1;
            opacity: 1;
        }

        .content {
            background-color: rgba(255, 255, 255, .8);
            border-radius: .25em;
            box-shadow: 0 0 .25em rgba(0, 0, 0, .25);
            box-sizing: border-box;
            left: 50%;
            padding: 10vmin;
            position: fixed;
            text-align: center;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        h1 {
            font-family: monospace;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="bg"></div>

    <div class="login-box">
        <div class="card card-outline card-primary" style="background-color:rgba(255,255,255,0.8)">
            <div class="card-header text-center">
                <b>E-Learning Satpol PP</b>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masukkan kode OTP yang dikirim ke email Anda</p>

                @if (session('status'))
                    <div class="alert alert-success text-center">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ url('otpverify') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="otp" class="form-control @error('otp') is-invalid @enderror"
                            placeholder="Masukkan Kode OTP" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                        @error('otp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
                        </div>
                    </div>
                </form>

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <a href="{{ url('login') }}" class="text-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
