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
                            <form method="GET" action="{{ route('hasilevaluasi.index') }}"
                                class="form-inline mb-3 float-right">

                                <!-- Filter kelas -->
                                <select name="filter_kelas" class="form-control mr-2">
                                    <option value="">-- Semua Kelas --</option>
                                    @foreach ($kategori_kelas as $kelas)
                                        <option value="{{ $kelas->id }}"
                                            {{ request('filter_kelas') == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Pencarian -->
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
                                                <a href="{{ route('hasilevaluasi.show', $item->id) }}">
                                                    <button class="btn btn-sm bg-info"><i class="fas fa-eye"></i></button>
                                                </a>
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
