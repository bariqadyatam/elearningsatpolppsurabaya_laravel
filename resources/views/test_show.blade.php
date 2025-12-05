@extends('layouts.app')

@section('content')
    <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
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

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-book mr-1"></i> Data Materi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQuizModal">
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

                        <a href="{{ route('materi.show', $data->materi_id) }}" class="btn btn-primary mb-3">
                            <i class="fas fa-arrow-left"></i> Kembali ke Materi
                        </a>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Pertanyaan</th>
                                    <th>Durasi (Detik)</th>
                                    <th>Opsi A</th>
                                    <th>Opsi B</th>
                                    <th>Opsi C</th>
                                    <th>Opsi D</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quiz as $q)
                                    <tr>
                                        <td>{{ Str::limit(strip_tags($q->pertanyaan), 60) }}</td>
                                        <td>{{ $q->durasi }}</td>
                                        <td>{{ $q->opsi_a }}</td>
                                        <td>{{ $q->opsi_b }}</td>
                                        <td>{{ $q->opsi_c }}</td>
                                        <td>{{ $q->opsi_d }}</td>
                                        <td><strong>{{ $q->jawaban }}</strong></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm bg-warning" data-toggle="modal"
                                                data-target="#editQuizModal{{ $q->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if ($data->sudah_dikerjakan > 0)
                                                {{-- Kalau sudah pernah dikerjakan, tombol hapus diganti --}}
                                                <span data-toggle="tooltip"
                                                    title="Tidak bisa dihapus, test ini sudah dikerjakan personel">
                                                    <button class="btn btn-sm bg-secondary">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </span>
                                            @else
                                                <form method="POST" action="{{ route('quiz.destroy', $q->id) }}"
                                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm bg-danger" title="Hapus Quiz">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>

                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editQuizModal{{ $q->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editQuizModalLabel{{ $q->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('quiz.update', $q->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Quiz</h5>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="test_id" value="{{ $q->test_id }}">

                                                        <div class="form-group">
                                                            <label>Pertanyaan</label>
                                                            <textarea name="pertanyaan" class="form-control editor" required>{{ $q->pertanyaan }}</textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Durasi (Detik)</label>
                                                            <input name="durasi" class="form-control" type="number"
                                                                min="10" value="{{ $q->durasi }}" required>
                                                        </div>

                                                        <div class="form-group"><label>Opsi A</label><input type="text"
                                                                name="opsi_a" value="{{ $q->opsi_a }}"
                                                                class="form-control" required></div>
                                                        <div class="form-group"><label>Opsi B</label><input type="text"
                                                                name="opsi_b" value="{{ $q->opsi_b }}"
                                                                class="form-control" required></div>
                                                        <div class="form-group"><label>Opsi C</label><input type="text"
                                                                name="opsi_c" value="{{ $q->opsi_c }}"
                                                                class="form-control" required></div>
                                                        <div class="form-group"><label>Opsi D</label><input type="text"
                                                                name="opsi_d" value="{{ $q->opsi_d }}"
                                                                class="form-control" required></div>

                                                        <div class="form-group">
                                                            <label>Jawaban Benar</label>
                                                            <select name="jawaban" class="form-control" required>
                                                                <option value="A"
                                                                    {{ $q->jawaban == 'A' ? 'selected' : '' }}>A</option>
                                                                <option value="B"
                                                                    {{ $q->jawaban == 'B' ? 'selected' : '' }}>B</option>
                                                                <option value="C"
                                                                    {{ $q->jawaban == 'C' ? 'selected' : '' }}>C</option>
                                                                <option value="D"
                                                                    {{ $q->jawaban == 'D' ? 'selected' : '' }}>D</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-warning">Update</button>
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
        </section>
    </div>

    <!-- Modal Tambah Quiz -->
    <div class="modal fade" id="addQuizModal" tabindex="-1" role="dialog" aria-labelledby="addQuizModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('quiz.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Quiz</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="test_id" value="{{ $data->id }}">

                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <textarea name="pertanyaan" id="editor" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Durasi (Detik)</label>
                            <input name="durasi" class="form-control" type="number" min="10" required>
                        </div>

                        <div class="form-group"><label>Opsi A</label><input type="text" name="opsi_a"
                                class="form-control" required></div>
                        <div class="form-group"><label>Opsi B</label><input type="text" name="opsi_b"
                                class="form-control" required></div>
                        <div class="form-group"><label>Opsi C</label><input type="text" name="opsi_c"
                                class="form-control" required></div>
                        <div class="form-group"><label>Opsi D</label><input type="text" name="opsi_d"
                                class="form-control" required></div>

                        <div class="form-group">
                            <label>Jawaban Benar</label>
                            <select name="jawaban" class="form-control" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CKEditor init -->
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
