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
                            <li class="breadcrumb-item"><a href="{{ route('materi.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('hasilevaluasi.index') }}" class="btn btn-primary mb-3">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar materi
        </a>

        <section class="content">
            <div class="container-fluid">

                {{-- Detail Materi --}}
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">Detail Materi</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Judul:</strong> {{ $data->judul }}</p>
                        <p><strong>Kategori:</strong> {{ $data->kategori->nama ?? '-' }}</p>
                        <p><strong>Kelas:</strong> {{ $data->kelas->nama ?? '-' }}</p>
                        <p><strong>Deskripsi:</strong></p>
                        <div>{!! $data->isi !!}</div>
                    </div>
                </div>

                {{-- Daftar Test --}}
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h3 class="card-title">Data Test</h3>

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
                                    <th>No</th>
                                    <th>Nama Test</th>
                                    <th>Sudah Dikerjakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($test as $index => $q)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $q->nama_test }}</td>
                                        <td>{{ $q->sudah_dikerjakan }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('evaluasi.show', $q->id) }}" class="btn btn-sm bg-info">
                                                <i class="fas fa-chart-line"></i> Lihat Evaluasi
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada test untuk materi ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
