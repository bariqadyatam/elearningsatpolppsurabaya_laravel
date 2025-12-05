@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-primary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h1 class="d-inline m-0">{{ $title }}</h1>
                </div>

                <a href="{{ route('evaluasi.cetak', $test->id) }}" target="_blank" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </a>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title">Informasi Test</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Nama Test:</strong> {{ $test->nama_test }}</p>
                        <p><strong>Materi:</strong> {{ $test->materi->judul }}</p>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Daftar Peserta & Hasil Evaluasi</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Personel</th>
                                    <th>Regu</th>
                                    <th>Kelas</th>
                                    <th>Skor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hasil as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $row->personel->nama ?? '-' }}</td>
                                        <td>{{ $row->personel->kategoriRegu->nama ?? '-' }}</td>
                                        <td>{{ $row->personel->kategoriRegu->kelas->nama ?? '-' }}</td>
                                        <td>{{ $row->skor }}</td>
                                        <td>
                                            @if ($row->sudah_mengerjakan)
                                                <span class="badge bg-success">Sudah</span>
                                            @else
                                                <span class="badge bg-secondary">Belum</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada hasil evaluasi.</td>
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
