<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Satpol PP | {{ $title }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.png') }}" type="image/x-icon">
    <!-- Link ke CSS AdminLTE -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @if (Auth::user()->role != 'Admin')
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#modalProfile">
                            Profile
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link <?php if($title=="Logout") {?>active<?php }?>">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->

            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">E-Learning Satpol PP</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->


                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if (Auth::user()->role === 'Admin')
                            <!-- Personel -->
                            <li class="nav-item">
                                <a href="{{ route('personel.index') }}"
                                    class="nav-link {{ $title == 'Personel' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>Personel</p>
                                </a>
                            </li>

                            <!-- Admin -->
                            <li class="nav-item">
                                <a href="{{ route('admin.index') }}"
                                    class="nav-link {{ $title == 'Admin' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>Admin</p>
                                </a>
                            </li>

                            <!-- Manajemen Kategori -->
                            <li
                                class="nav-item {{ in_array($title, ['Kategori Kelas', 'Kategori Regu', 'Kategori Materi']) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ in_array($title, ['Kategori Kelas', 'Kategori Regu', 'Kategori Materi']) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        Manajemen Kategori
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('kategori_kelas.index') }}"
                                            class="nav-link {{ $title == 'Kategori Kelas' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Kelas</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('kategori_regu.index') }}"
                                            class="nav-link {{ $title == 'Kategori Regu' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Regu</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('kategori_materi.index') }}"
                                            class="nav-link {{ $title == 'Kategori Materi' ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Kategori Materi</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <!-- Hasil Evaluasi -->
                            <li class="nav-item">
                                <a href="{{ route('hasilevaluasi.index') }}"
                                    class="nav-link {{ $title == 'Hasil Evaluasi' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-poll"></i>
                                    <p>Hasil Evaluasi</p>
                                </a>
                            </li>
                        @endif

                        <!-- Materi -->
                        <li class="nav-item">
                            <a href="{{ route('materi.index') }}"
                                class="nav-link {{ $title == 'Materi' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>Materi</p>
                            </a>
                        </li>

                    </ul>

                </nav>


                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        @yield('content')
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} E-Learning Satpol PP.</strong>

            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 0.0.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Modal Profile -->
    <div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="modalProfileLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="formProfile" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-user-circle mr-2"></i> Update Profil</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <!-- Foto Profil -->
                        <div class="text-center mb-4">
                            @php
                                $foto = optional(Auth::user()->personel)->foto;
                            @endphp
                            <img src="{{ $foto && $foto !== 'personel/foto/default.jpg' ? asset('storage/' . $foto) : asset('storage/personel/foto/default.jpg') }}"
                                class="rounded-circle img-thumbnail" alt="Foto Profil" width="130"
                                height="130">
                            <div class="mt-2">
                                <input type="file" name="foto" class="form-control-file">
                                <small class="form-text text-muted">Pilih foto baru untuk mengganti.</small>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body">

                                <!-- Nama -->
                                <div class="form-group">
                                    <label><i class="fas fa-id-card mr-1"></i> Nama</label>
                                    <input type="text" class="form-control"
                                        value="{{ optional(Auth::user()->personel)->nama }}" disabled>
                                </div>

                                <!-- Username -->
                                <div class="form-group">
                                    <label><i class="fas fa-user mr-1"></i> Username</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->username }}"
                                        disabled>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="form-group">
                                    <label><i class="fas fa-birthday-cake mr-1"></i> Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ optional(Auth::user()->personel)->tanggal_lahir }}">
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label><i class="fas fa-lock mr-1"></i> Password Lama</label>
                                    <input type="password" name="passwordlama" class="form-control"
                                        placeholder="Kosongkan jika tidak diganti">
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-lock mr-1"></i> Password Baru</label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Kosongkan jika tidak diganti">
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-lock mr-1"></i> Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Kosongkan jika tidak diganti">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @yield('scripts')
</body>
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- DataTables & Plugins -->
<script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    $('#formProfile').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    alert('Profil berhasil diperbarui!');
                    location.reload();
                } else {
                    alert(res.message || 'Terjadi kesalahan.');
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan. Silakan coba lagi.';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        // ambil error pertama dari validasi Laravel
                        const firstError = Object.values(xhr.responseJSON.errors)[0];
                        message = Array.isArray(firstError) ? firstError[0] : firstError;
                    }
                }

                alert(message);
            }
        });
    });
</script>


@yield('scripts')

</html>
