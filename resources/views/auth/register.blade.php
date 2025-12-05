<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>E-Learning Satpol PP | Registration</title>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <style>
    html { height:100%; padding:0; }
    body { margin:0; padding:0; }
    .bg {
      background-image: url('assets/bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      position: fixed;
      top: 0; right: 0; bottom: 0; left: 0;
      z-index: -1;
      opacity: 1;
    }
  </style>
</head>
<body class="hold-transition register-page">
<div class="bg"></div>

<div class="register-box">
  <div class="card card-outline card-primary" style="background-color:rgba(255,255,255,0.9)">
    <div class="card-header text-center">
      <b>E-Learning Satpol PP</b>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Registrasi Akun Personel</p>

      <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Username -->
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                 name="username" value="{{ old('username') }}" required autocomplete="username"
                 placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
          @error('username')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Nama -->
        <div class="input-group mb-3">
          <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror"
                 name="nama" value="{{ old('nama') }}" required placeholder="Nama Lengkap">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-id-card"></span></div>
          </div>
          @error('nama')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Pilih Regu -->
        <div class="input-group mb-3">
          <select id="id_kategori_regu" name="id_kategori_regu"
                  class="form-control @error('id_kategori_regu') is-invalid @enderror" required>
            <option value="">-- Pilih Regu --</option>
            @foreach($kategoriRegu as $regu)
              <option value="{{ $regu->id }}" {{ old('id_kategori_regu')==$regu->id ? 'selected':'' }}>
                {{ $regu->nama }}
              </option>
            @endforeach
          </select>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-users"></span></div>
          </div>
          @error('id_kategori_regu')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Tanggal Lahir -->
        <div class="input-group mb-3">
          <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                 class="form-control @error('tanggal_lahir') is-invalid @enderror"
                 value="{{ old('tanggal_lahir') }}" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-calendar"></span></div>
          </div>
          @error('tanggal_lahir')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Upload Foto (opsional) -->
        <div class="input-group mb-3">
          <input type="file" id="foto" name="foto"
                 class="form-control @error('foto') is-invalid @enderror" accept="image/*">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-image"></span></div>
          </div>
          @error('foto')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
          <input id="password" type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 name="password" required autocomplete="new-password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
          @error('password')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="input-group mb-3">
          <input id="password-confirm" type="password" class="form-control"
                 name="password_confirmation" required autocomplete="new-password"
                 placeholder="Konfirmasi Password">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>

        <!-- Tombol Submit -->
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
