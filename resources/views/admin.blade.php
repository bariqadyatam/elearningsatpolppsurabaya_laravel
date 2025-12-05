@extends('layouts.app')

@section('content')
    @if (Auth::user()->role === 'Admin')
        <div class="content-wrapper">
            <!-- Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $title }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-shield"></i> Data Admin</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addAdminModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <form method="GET" action="{{ route('admin.index') }}" class="form-inline mb-3 float-right">
                                <input type="text" name="search" class="form-control mr-2" placeholder="Cari Nama Admin"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>NIP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admins as $item)
                                            <tr>
                                                <td>{{ $item->username }}</td>
                                                <td>{{ $item->email ?? '-' }}</td>
                                                <td>{{ $item->nip }}</td>
                                                <td class="text-center">
                                                    <!-- Tombol Edit -->
                                                    <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <!-- Tombol Delete (kecuali admin pertama id=1) -->
                                                    @if ($item->id != auth()->user()->id)
                                                        <form method="POST"
                                                            action="{{ route('admin.destroy', $item->id) }}"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm bg-danger"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal Tambah Admin -->
        <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Admin</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label>NIP</label><input type="number" name="nip"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Username</label><input type="text" name="username"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Email</label><input type="email" name="email"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Password</label><input type="password" name="password"
                                    class="form-control" required></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Admin -->
        @foreach ($admins as $item)
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label>NIP</label><input type="number" name="nip"
                                        value="{{ $item->nip }}" class="form-control" required></div>
                                <div class="form-group"><label>Username</label><input type="text" name="username"
                                        value="{{ $item->username }}" class="form-control" required></div>
                                <div class="form-group"><label>Email</label><input type="email" name="email"
                                        value="{{ $item->email }}" class="form-control" required></div>

                                @if ($item->id == auth()->user()->id)
                                    <div class="form-group"><label>Password Lama (kosongkan jika tidak
                                            diubah)</label><input type="password" name="passwordlama"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password Baru</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            class="form-control">
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endsection
@else
    <div class="container mt-5">
        <div class="alert alert-danger text-center">
            <h4><i class="fas fa-exclamation-triangle"></i> Dilarang Akses</h4>
            <p>Anda tidak memiliki hak akses ke halaman ini.</p>
        </div>
    </div>
@endif
