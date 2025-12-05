@extends('layouts.app')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<style>
    .table th,
    .table td {
        white-space: nowrap;
    }

    /* Carousel styling agar gambar tidak hanya tampil bagian atas */
    .carousel-inner {
        width: 100%;
        height: 500px; /* tinggi tetap agar tidak lompat-lompat */
    }

    .carousel-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;     /* supaya penuh */
        object-position: center center; /* supaya bagian tengah yang ditampilkan */
    }
</style>



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

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('materi.index') }}" class="btn btn-primary">
            ← Kembali ke Daftar Materi
        </a>
    </div>
    <section class="content">
        <div class="container-fluid">            
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Materi: {{ $data->judul }} ({{ $data->kategori->nama ?? '-' }})</h3>
                        </div>

                        <div class="card-body">
                            {{-- Carousel --}}
                            <div id="carouselMateriImages" class="carousel slide mb-4" data-ride="carousel">
                                <div class="carousel-inner">
                                    {{-- Thumbnail --}}
                                    @if ($data->thumbnail)
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/' . $data->thumbnail) }}" class="d-block w-100 img-fluid rounded" alt="Thumbnail">
                                        </div>
                                    @endif

                                    {{-- Gambar tambahan --}}
                                    @php
                                        $imageList = json_decode($data->images, true) ?? [];
                                    @endphp

                                    @foreach ($imageList as $index => $img)
                                        <div class="carousel-item @if(!$data->thumbnail && $index == 0) active @endif">
                                            <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 img-fluid rounded" alt="Image {{ $index + 1 }}">
                                        </div>
                                    @endforeach

                                    {{-- Fallback jika tidak ada gambar --}}
                                    @if (!$data->thumbnail && empty(json_decode($data->images)))
                                        <div class="carousel-item active">
                                            <div class="bg-secondary text-white text-center p-5">Tidak ada gambar</div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Kontrol panah --}}
                                @if ($data->thumbnail || (json_decode($data->images) && count(json_decode($data->images)) > 1))
                                    <a class="carousel-control-prev" href="#carouselMateriImages" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselMateriImages" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </a>
                                @endif
                            </div>

                            {{-- Isi Materi --}}
                            <div class="mt-4 text-justify">
                                <p class="mb-1">{!! $data->isi ?? '-' !!}</p>

                                @if ($data->video)
                                    <p class="mb-1">
                                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#videoModal">
                                            Lihat Video
                                        </button>
                                    </p>

                                    <!-- Modal -->
                                    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title mb-1" id="videoModalLabel">Video Materi</h5>
                                                        <small class="text-muted d-block">
                                                            {{ $data->deskripsi_video ?? 'Harap pause video sebelum menutup video' }}
                                                        </small>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="stopVideo()">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe id="videoFrame"
                                                            class="embed-responsive-item"
                                                            data-src="{{ Str::contains($data->video, 'youtu.be') 
                                                                            ? 'https://www.youtube.com/embed/' . Str::afterLast($data->video, '/') 
                                                                            : (Str::contains($data->video, 'youtube.com') 
                                                                                ? 'https://www.youtube.com/embed/' . Str::after($data->video, 'v=') 
                                                                                : $data->video) }}"
                                                            src="{{ Str::contains($data->video, 'youtu.be') 
                                                                        ? 'https://www.youtube.com/embed/' . Str::afterLast($data->video, '/') 
                                                                        : (Str::contains($data->video, 'youtube.com') 
                                                                            ? 'https://www.youtube.com/embed/' . Str::after($data->video, 'v=') 
                                                                            : $data->video) }}"
                                                            allowfullscreen>
                                                    </iframe>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Script to stop video when modal is closed -->
                                    <script>
                                        function stopVideo() {
                                            var iframe = document.getElementById("videoFrame");
                                            iframe.src = ""; // Kosongkan src dulu
                                            setTimeout(function () {
                                                iframe.src = iframe.getAttribute("data-src"); // Set ulang src-nya
                                            }, 100); // Delay dikit untuk trigger reload
                                        }

                                        // Trigger stop saat modal ditutup
                                        $('#videoModal').on('hidden.bs.modal', function () {
                                            stopVideo();
                                        });
                                    </script>

                                @endif
                            </div>

                        </div>
                    </div>
                    
                    <div class="card mb-3" id="{{ $data->id }}">
                        <div class="card-body">
                            <h5>Daftar File Materi:</h5>

                            @if($data->links && count($data->links))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data->links as $q)
                                                <tr>
                                                    <td class="text-break">{{ $q->nama_link }}</td>
                                                    <td class="text-break">{{ $q->deskripsi_link }}</td>
                                                    <td>
                                                        @if ($q->link)
                                                            <a href="{{ asset('storage/' . $q->link) }}" target="_blank" class="btn btn-sm btn-info">
                                                                <i class="fas fa-download"></i> Lihat/Download File
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Tidak Ada File</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada file materi.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4 col-12 mt-3 mt-lg-0">

                    <div class="card mb-3" id="materi-belum-selesai">
                        <div class="card-body">
                            <h5>Materi Lain yang Belum Selesai:</h5>

                            @if(count($materi_belum_selesai))
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Judul Materi</th>
                                                <th>Deskripsi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($materi_belum_selesai as $m)
                                                <tr>
                                                    <td class="text-break">{{ $m->judul }}</td>
                                                    <td class="text-break">{{ Str::limit(strip_tags($m->isi), 100, '...') }}</td>
                                                    <td>
                                                        <a href="{{ route('materi.show', $m->id) }}" class="btn btn-sm btn-outline-primary">
                                                            📖 Lihat Materi
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada materi lain yang belum dikerjakan.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3" id="{{ $data->id }}">
                        <div class="card-body">
                            <h5>Daftar Test:</h5>
                            @if($data->tests && count($data->tests))
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Test</th>
                                                <th>Skor</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    @foreach($data->tests as $q)
                                        <tr>
                                            <td class="text-break">{{$q->nama_test}}</td>
                                            <td>{{$q->skor}}</td>
                                            <td>
                                                @if ($q->status === null)
                                                    <a href="{{ route('quiz.kerjakan', $q->id) }}" class="btn btn-primary">
                                                        Kerjakan
                                                    </a>
                                                @else
                                                    <button class="btn btn-success" disabled>
                                                        ✅ Sudah Dikerjakan
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada test yang tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3" id="{{ $data->id }}">
                        <div class="card-body">
                            <h5>Hasil Sertifikat:</h5>
                            @if($status === "Belum Selesai")
                                <p class="text-muted">Test Belum/Selesai Dikerjakan</p>
                            @else
                                <a 
                                    href="{{ route('sertifikat.generate', [
                                        'nama' => $personel->nama,
                                        'personel_id' => $personel->id,
                                        'materi_id' => $data->id,
                                        'materi' => $data->judul,
                                        'tanggal' => now()->format('Y-m-d')
                                    ]) }}" 
                                    target="_blank" 
                                    class="btn btn-outline-success"
                                >
                                    📜 Download Sertifikat PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- Bootstrap 4 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>


{{-- Bootstrap Carousel JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
