@if (Auth::user()->role === 'Admin')
    @extends('layouts.app')

    @section('content')
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
                            <h3 class="card-title"><i class="fas fa-users mr-1"></i> Data Personel</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#addPersonelModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <form method="GET" action="{{ route('personel.index') }}"
                                class="form-inline mb-3 float-right">
                                <input type="text" name="search" class="form-control mr-2"
                                    placeholder="Cari Nama Personel" value="{{ request('search') }}">
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
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Kelas</th>
                                            <th>Regu</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($personels as $item)
                                            <tr>
                                                <td><img src="{{ asset('storage/' . $item->foto) }}" width="50"
                                                        class="rounded-circle" alt="foto"></td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->user->email }}</td>
                                                <td>{{ $item->user->username }}</td>
                                                <td>{{ $item->kategoriRegu->kelas->nama ?? '-' }}</td>
                                                <td>{{ $item->kategoriRegu->nama ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('personel.destroy', $item->id) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm bg-danger"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
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

        <!-- Modal Tambah Personel -->
        <div class="modal fade" id="addPersonelModal" tabindex="-1" role="dialog" aria-labelledby="addPersonelModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('personel.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Personel</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label>Nama</label><input type="text" name="nama"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Email</label><input type="email" name="email"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Username</label><input type="text" name="username"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Password</label><input type="password" name="password"
                                    class="form-control" required></div>
                            <div class="form-group">
                                <label>Regu</label>
                                <select name="kategori_regu_id" class="form-control" required>
                                    @foreach ($kategori_regus as $regu)
                                        <option value="{{ $regu->id }}">{{ $regu->nama }}
                                            ({{ $regu->kelas->nama }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir"
                                    class="form-control" required></div>
                            <div class="form-group"><label>Foto</label><input type="file" name="foto"
                                    class="form-control"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Personel -->
        @foreach ($personels as $item)
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('personel.update', $item->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Personel</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label>Nama</label><input type="text" name="nama"
                                        value="{{ $item->nama }}" class="form-control" required></div>
                                <div class="form-group"><label>Email</label><input type="email" name="email"
                                        value="{{ $item->user->email }}" class="form-control" required></div>
                                <div class="form-group"><label>Username</label><input type="text" name="username"
                                        value="{{ $item->user->username }}" class="form-control" required></div>
                                {{-- <div class="form-group"><label>Password (kosongkan jika tidak diubah)</label><input
                                        type="password" name="password" class="form-control"></div> --}}
                                <div class="form-group">
                                    <label>Regu</label>
                                    <select name="kategori_regu_id" class="form-control" required>
                                        @foreach ($kategori_regus as $regu)
                                            <option value="{{ $regu->id }}"
                                                {{ $item->kategori_regu_id == $regu->id ? 'selected' : '' }}>
                                                {{ $regu->nama }} ({{ $regu->kelas->nama }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label>Tanggal Lahir</label><input type="date"
                                        name="tanggal_lahir" value="{{ $item->tanggal_lahir }}" class="form-control"
                                        required></div>
                                <div class="form-group"><label>Foto (optional)</label><input type="file"
                                        name="foto" class="form-control"></div>
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
@endif
