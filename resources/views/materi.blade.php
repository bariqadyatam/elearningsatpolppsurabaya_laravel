@extends('layouts.app')

@section('content')
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

        <!-- Main -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-book mr-1"></i> Data Materi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#addMateriModal">
                                <i class="fas fa-plus"></i>
                            </button>
                            <form method="GET" action="{{ route('materi.index') }}" class="form-inline mb-3 float-right">
                                <input type="text" name="search" class="form-control mr-2"
                                    placeholder="Cari Judul Materi..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </form>
                            <div class="clearfix"></div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Kelas</th>
                                        <th>Jumlah Personel</th>
                                        <th>Isi</th>
                                        <th>Video Materi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Thumbnail</th>
                                        <th>Images</th>
                                        <th>No Sertifikat</th>
                                        <th>Pernyataan Sertifikat</th>
                                        <th>Keterangan Sertifikat</th>
                                        <th>Foto Tanda Tangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($materis as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->kategori->nama ?? '-' }}</td>
                                            <td>{{ $item->kelas->nama ?? '-' }}</td>
                                            <td>{{ $item->jumlah_kelas }}</td>
                                            <td>{{ $item->jumlah_personel }}</td>
                                            <td>{!! Str::limit($item->isi, 100) !!}</td>
                                            <td>
                                                @if ($item->video)
                                                    <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#videoModal{{ $item->id }}">Lihat Video</button>

                                                    <!-- Modal Embed YouTube -->
                                                    <div class="modal fade" id="videoModal{{ $item->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="videoModalLabel{{ $item->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="videoModalLabel{{ $item->id }}">Video
                                                                        Materi</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Tutup">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="embed-responsive embed-responsive-16by9">
                                                                        <iframe class="embed-responsive-item"
                                                                            src="{{ preg_match('/youtu\.be|youtube\.com/', $item->video) ? str_replace('watch?v=', 'embed/', $item->video) : $item->video }}"
                                                                            allowfullscreen></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($item->thumbnail)
                                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Thumbnail"
                                                        width="80">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->images)
                                                    @foreach (json_decode($item->images, true) as $img)
                                                        <img src="{{ asset('storage/' . $img) }}" width="50"
                                                            class="mb-1">
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->no_sertif ?? '-' }}</td>
                                            <td>{{ Str::limit($item->pernyataan_sertifikat, 30) }}</td>
                                            <td>{{ Str::limit($item->keterangan_sertifikat, 30) }}</td>
                                            <td>
                                                @if ($item->foto_tanda_tangan)
                                                    <img src="{{ asset('storage/' . $item->foto_tanda_tangan) }}"
                                                        width="100">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('materi.show', $item->id) }}">
                                                    <button class="btn btn-sm bg-info"><i class="fas fa-eye"></i></button>
                                                </a>
                                                <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                    data-target="#editModal{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ route('materi.destroy', $item->id) }}"
                                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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

    <!-- Modal Tambah Materi -->
    <div class="modal fade" id="addMateriModal" tabindex="-1" role="dialog" aria-labelledby="addMateriModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="{{ route('materi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Materi</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"><label>Judul</label><input type="text" name="judul"
                                class="form-control" required></div>
                        @if (empty($idkategorimateri))
                            <div class="form-group"><label>Kategori</label>
                                <select name="kategori_materi_id" class="form-control" required>
                                    @foreach ($kategori_materi as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="kategori_materi_id" id=""
                                value="{{ $idkategorimateri }}">
                        @endif
                        <div class="form-group"><label>Kelas</label>
                            <select name="kategori_kelas_id" class="form-control" required>
                                @foreach ($kategori_kelas as $value)
                                    <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group quill-container"><label>Isi</label>
                            <textarea name="isi" class="form-control" style="display: none;"></textarea>
                        </div>
                        <div class="form-group"><label>Video (URL)</label><input type="url" name="video"
                                class="form-control"></div>
                        <div class="form-group"><label>Thumbnail</label><input type="file" name="thumbnail"
                                class="form-control-file"></div>
                        <div class="form-group">
                            <label>Gambar Tambahan</label>
                            <input type="file" name="images[]" class="form-control-file" multiple>
                            <small class="text-muted">Boleh memilih lebih dari satu gambar.</small>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>

                        <div class="text-center my-4">
                            <span
                                style="display: inline-block; width: 100%; border-bottom: 1px solid #ccc; line-height: 0.1em; margin: 10px 0 20px;">
                                <span style="background:#fff; padding:0 10px; font-weight: bold;">Bagian Sertifikat</span>
                            </span>
                        </div>

                        <!-- Gambar di tengah -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/penjelasan_sertif/penjelasan_sertifikat.png') }}"
                                alt="Contoh Sertifikat" style="max-width: 200px; cursor: pointer;" data-toggle="modal"
                                data-target="#popupGambar">
                        </div>

                        <!-- Popup Modal untuk gambar -->
                        <div class="modal fade" id="popupGambar" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-transparent border-0 shadow-none">
                                    <img src="{{ asset('storage/penjelasan_sertif/penjelasan_sertifikat.png') }}"
                                        alt="Contoh Sertifikat" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                        <div class="form-group"><label>Nomor Sertif</label><input type="text" name="no_sertif"
                                class="form-control" required></div>
                        <div class="form-group"><label>Pernyataan Sertifikat</label><input type="text"
                                name="pernyataan_sertifikat" class="form-control" required></div>
                        <div class="form-group"><label>Keterangan Sertifikat</label><input type="text"
                                name="keterangan_sertifikat" class="form-control" required></div>
                        <div class="form-group"><label>Foto Tanda Tangan</label><input type="file"
                                name="foto_tanda_tangan" class="form-control-file"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Materi -->
    @foreach ($materis as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form method="POST" action="{{ route('materi.update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Materi</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label>Judul</label><input type="text" name="judul"
                                    value="{{ $item->judul }}" class="form-control" required></div>
                            @if (empty($idkategorimateri))
                                <div class="form-group"><label>Kategori</label>
                                    <select name="kategori_materi_id" class="form-control" required>
                                        @foreach ($kategori_materi as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ $item->kategori_materi_id == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="kategori_materi_id" id=""
                                    value="{{ $idkategorimateri }}">
                            @endif

                            <div class="form-group"><label>Kelas</label>
                                <select name="kategori_kelas_id" class="form-control" required>
                                    @foreach ($kategori_kelas as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $item->kategori_kelas_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group quill-container"><label>Isi</label>
                                <textarea name="isi" class="form-control" style="display: none;">{!! $item->isi !!}</textarea>
                            </div>
                            <div class="form-group"><label>Video (URL)</label><input type="url" name="video"
                                    value="{{ $item->video }}" class="form-control"></div>
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ $item->start_date }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ $item->end_date }}"
                                    class="form-control">
                            </div>
                            <div class="text-center my-4">
                                <span
                                    style="display: inline-block; width: 100%; border-bottom: 1px solid #ccc; line-height: 0.1em; margin: 10px 0 20px;">
                                    <span style="background:#fff; padding:0 10px; font-weight: bold;">Bagian
                                        Sertifikat</span>
                                </span>
                            </div>

                            <!-- Gambar di tengah -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/penjelasan_sertif/penjelasan_sertifikat.png') }}"
                                    alt="Contoh Sertifikat" style="max-width: 200px; cursor: pointer;"
                                    data-toggle="modal" data-target="#popupGambarEdit{{ $item->id }}">
                            </div>

                            <!-- Popup Modal untuk gambar -->
                            <div class="modal fade" id="popupGambarEdit{{ $item->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                        <img src="{{ asset('storage/penjelasan_sertif/penjelasan_sertifikat.png') }}"
                                            alt="Contoh Sertifikat" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label>Nomor Sertif</label><input type="text" name="no_sertif"
                                    class="form-control" value="{{ $item->no_sertif }}" required></div>
                            <div class="form-group"><label>Pernyataan Sertifikat</label><input type="text"
                                    name="pernyataan_sertifikat" value="{{ $item->pernyataan_sertifikat }}"
                                    maxlength="250" class="form-control" required></div>
                            <div class="form-group"><label>Keterangan Sertifikat</label><input type="text"
                                    name="keterangan_sertifikat" value="{{ $item->keterangan_sertifikat }}"
                                    class="form-control" required></div>
                            <div class="form-group">
                                <label>Foto Tanda Tangan</label>
                                <input type="file" name="foto_tanda_tangan" class="form-control-file">
                                @if ($item->foto_tanda_tangan)
                                    <p class="mt-2">Foto Tanda Tangan Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $item->foto_tanda_tangan) }}" width="80">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control-file">
                                @if ($item->thumbnail)
                                    <p class="mt-2">Thumbnail Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" width="80">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Ganti Gambar Tambahan</label>
                                <input type="file" name="images[]" class="form-control-file" multiple>
                                <small class="text-muted">Upload ulang jika ingin mengganti seluruh gambar
                                    tambahan.</small>
                                @if ($item->images)
                                    <p class="mt-2">Gambar Saat Ini:</p>
                                    @foreach (json_decode($item->images, true) as $img)
                                        <img src="{{ asset('storage/' . $img) }}" width="50" class="mb-1">
                                    @endforeach
                                @endif
                            </div>
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

    <!-- Quill Editor -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

    <style>
        .quill-editor {
            height: 200px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editors = document.querySelectorAll('.quill-container');

            editors.forEach(function(container) {
                const textarea = container.querySelector('textarea');
                const editorDiv = document.createElement('div');
                editorDiv.classList.add('quill-editor');
                container.insertBefore(editorDiv, textarea);
                textarea.style.display = 'none';

                const quill = new Quill(editorDiv, {
                    theme: 'snow'
                });

                // Set initial value if editing
                if (textarea.value) {
                    quill.root.innerHTML = textarea.value;
                }

                // Sync on form submit
                container.closest('form').addEventListener('submit', function() {
                    textarea.value = quill.root.innerHTML;
                });
            });
        });
    </script>

@endsection
