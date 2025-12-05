@extends('layouts.app')

@section('content')
    <script src="https://cdn.ckeditor.com/ 4.25.1-lts/standard/ckeditor.js"></script>
    <div class="content-wrapper">
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
        <a href="{{ route('materi.index') }}" class="btn btn-primary mb-3">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar materi
        </a>

        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $data->judul }}</h3>
                    </div>
                    <div class="card-body">
                        <!-- Nav Tabs -->
                        <ul class="nav nav-tabs" id="materiTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info"
                                    role="tab">Info Materi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="link-tab" data-toggle="tab" href="#link" role="tab">Upload
                                    File Materi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab">Test</a>
                            </li>
                            
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3">
                            <!-- Info Materi -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Judul</th>
                                        <td>{{ $data->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Materi</th>
                                        <td>{{ $data->kategori->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Isi</th>
                                        <td>{!! $data->isi !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Vidio</Video></th>
                                        <td>
                                            @if ($data->video)
                                                <a href="{{ $data->video }}" target="_blank">Lihat Video</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>



                            <!-- Pemasukan -->
                            <div class="tab-pane fade" id="test" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-book mr-1"></i> Data Test</h3>
                                        <!-- Tombol Add Quiz -->
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#addTestModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

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

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Test</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($test as $q)
                                                    <tr>
                                                        <td>{{ $q->nama_test }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('test.show', $q->id) }}">
                                                                <button class="btn btn-sm bg-info"><i
                                                                        class="fas fa-eye"></i></button>
                                                            </a>
                                                            <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                                data-target="#editTestModal{{ $q->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>

                                                            @if ($q->sudah_dikerjakan > 0)
                                                                <button class="btn btn-sm bg-secondary"
                                                                    title="Tidak bisa dihapus, sudah dikerjakan personel">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            @else
                                                                <form method="POST"
                                                                    action="{{ route('test.destroy', $q->id) }}"
                                                                    class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm bg-danger" title="Hapus Test">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </td>

                                                    </tr>

                                                    <!-- Modal Edit Quiz -->
                                                    <div class="modal fade" id="editTestModal{{ $q->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editTestModalLabel{{ $q->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('test.update', $q->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Test</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="materi_id"
                                                                            value="{{ $q->materi_id }}">

                                                                        <div class="form-group"><label>Nama
                                                                                Test</label><input type=""
                                                                                name="nama_test"
                                                                                value="{{ $q->nama_test }}"
                                                                                class="form-control" required></div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-warning">Update</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <!-- Pemasukan -->
                            <div class="tab-pane fade" id="link" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-book mr-1"></i> Daftar File Materi</h3>
                                        <!-- Tombol Add Link -->
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#addLinkModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

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

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Deskripsi</th>
                                                    <th>File</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($link as $q)
                                                    <tr>
                                                        <td>{{ $q->nama_link }}</td>
                                                        <td>{{ $q->deskripsi_link }}</td>
                                                        <td>
                                                            @if ($q->link)
                                                                <a href="{{ asset('storage/' . $q->link) }}"
                                                                    target="_blank" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-download"></i> Lihat File
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Tidak ada file</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                                data-target="#editLinkModal{{ $q->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form method="POST"
                                                                action="{{ route('link.destroy', $q->id) }}"
                                                                class="d-inline"
                                                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm bg-danger"><i
                                                                        class="fas fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit Link -->
                                                    <div class="modal fade" id="editLinkModal{{ $q->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="editLinkModalLabel{{ $q->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('link.update', $q->id) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Link</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"><span>&times;</span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="materi_id"
                                                                            value="{{ $q->materi_id }}">

                                                                        <div class="form-group">
                                                                            <label>Nama File</label>
                                                                            <input type="text" name="nama_link"
                                                                                value="{{ $q->nama_link }}"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Deskripsi</label>
                                                                            <textarea name="deksripsi_link" class="form-control" rows="3" required>{{ $q->deskripsi_link }}</textarea>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Ganti File (Opsional)</label>
                                                                            <input type="file" name="link"
                                                                                class="form-control-file">
                                                                            <small class="text-muted">Kosongkan jika tidak
                                                                                ingin mengganti.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-warning">Update</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- Personel -->
                            <div class="tab-pane fade" id="personel" role="tabpanel">
                                @if ($personel_selesai->count())
                                    <form action="{{ route('sertifikat.storeBatch') }}" method="POST">
                                        @csrf
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Foto</th>
                                                    <th>Nama Personel</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($personel_selesai as $pivot)
                                                    <tr>
                                                        <td>
                                                            @if ($pivot->personel && $pivot->personel->foto)
                                                                <img src="{{ asset('storage/' . $pivot->personel->foto) }}"
                                                                    alt="Foto Personel" width="60" height="60"
                                                                    style="object-fit: cover; border-radius: 50%;">
                                                            @else
                                                                <img src="{{ asset('storage/personel/foto/default.jpg') }}"
                                                                    alt="Default Foto" width="60" height="60"
                                                                    style="object-fit: cover; border-radius: 50%;">
                                                            @endif
                                                        </td>
                                                        <td>{{ $pivot->personel->nama ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                @else
                                    <p class="text-muted">Belum ada yang mengerjakan materi ini.</p>
                                @endif
                            </div>


                        </div> <!-- end tab content -->



                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- jQuery (for Bootstrap tabs if not loaded) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Modal Tambah Link -->
    <div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="addLinkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('link.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Link Materi</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="materi_id" value="{{ $data->id }}">

                        <div class="form-group">
                            <label for="nama_link">Nama File</label>
                            <input type="text" name="nama_link" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="deksripsi_link">Deskripsi</label>
                            <textarea name="deksripsi_link" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="link">Upload File (PDF/DOC/PPT/MP4/ZIP)</label>
                            <input type="file" name="link" class="form-control-file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Link -->
    <div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="addTestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('test.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Test</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="materi_id" value="{{ $data->id }}">

                        <div class="form-group">
                            <label for="nama_link">Nama Test</label>
                            <input type="text" name="nama_test" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
