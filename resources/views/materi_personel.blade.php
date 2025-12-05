@extends('layouts.app')

@section('content')
<style>
    .link-card {
        color: inherit;
        text-decoration: none;
    }
</style>

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
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i> Data Materi</h3>
                    <form method="GET" action="{{ route('materi.index') }}" class="form-inline mb-3 float-right">
                        <input type="text" name="search" class="form-control mr-2" placeholder="Cari Judul Materi..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="clearfix"></div>
                </div>

                <div class="card-body">
                    {{-- Flash Message --}}
                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- List Materi --}}
                    @foreach ($materis as $item)
                        <a href="{{ route('materi.show', $item->id) }}" style="color: inherit; text-decoration: none;">
                            <div class="d-flex border rounded p-3 mb-3 align-items-start materi-item" style="cursor:pointer;">
                                <div style="width: 150px; flex-shrink: 0;">
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" class="img-fluid rounded" alt="Thumbnail">
                                    @else
                                        <div class="bg-secondary text-white text-center p-4 rounded">Tidak ada gambar</div>
                                    @endif
                                </div>

                                <div class="ml-3 flex-grow-1">
                                    <h5>{{ $item->judul }}</h5>
                                    <p class="mb-1"><strong>Kategori:</strong> {{ $item->kategori->nama ?? '-' }}</p>
                                    <p class="mb-1"><strong>Score:</strong> {{ $item->skor ?? '-' }}</p>
                                    <p class="mb-0 text-muted">
                                    <strong>Periode:</strong> 
                                    {{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') : '-' }} 
                                    s/d 
                                    {{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </a>

                    @endforeach

                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-md-4">
            <img id="modal-thumbnail" src="" class="img-fluid rounded mb-3" alt="Thumbnail">
        </div>
        <div class="col-md-8">
            <h5 id="modal-judul"></h5>
            <p><strong>Kategori:</strong> <span id="modal-kategori"></span></p>
            <p><strong>Isi:</strong> <span id="modal-isi"></span></p>
            <p><strong>Video:</strong> <a href="#" target="_blank" id="modal-video">Lihat Video</a></p>
            <p><strong>Score:</strong> <span id="modal-skor"></span></p>
            <p><strong>Status:</strong> <span id="modal-status"></span></p>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" id="modal-kerjakan-btn" class="btn btn-primary">Kerjakan Quiz</a>
        <button class="btn btn-secondary" id="modal-sudah-btn" disabled>Sudah Dikerjakan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.materi-item').forEach(item => {
        item.addEventListener('click', function () {
            const id = this.dataset.id;
            const judul = this.dataset.judul;
            const kategori = this.dataset.kategori;
            const isi = this.dataset.isi;
            const video = this.dataset.video;
            const skor = this.dataset.skor;
            const status = this.dataset.status;
            const thumbnail = this.dataset.thumbnail;

            document.getElementById('modal-judul').textContent = judul;
            document.getElementById('modal-kategori').textContent = kategori;
            document.getElementById('modal-isi').textContent = isi;
            document.getElementById('modal-skor').textContent = skor;
            document.getElementById('modal-status').textContent = status;
            document.getElementById('modal-thumbnail').src = thumbnail || 'https://via.placeholder.com/150';
            document.getElementById('modal-video').href = video || '#';
            document.getElementById('modal-video').textContent = video ? 'Lihat Video' : '-';

            const kerjakanBtn = document.getElementById('modal-kerjakan-btn');
            const sudahBtn = document.getElementById('modal-sudah-btn');

            if (status === 'Belum Dikerjakan' || skor === '-') {
                kerjakanBtn.href = `/quiz/${id}/kerjakan`;
                kerjakanBtn.style.display = 'inline-block';
                sudahBtn.style.display = 'none';
            } else {
                kerjakanBtn.style.display = 'none';
                sudahBtn.style.display = 'inline-block';
            }
        });
    });
});
</script>
@endsection
