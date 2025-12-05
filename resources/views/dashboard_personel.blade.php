@extends('layouts.app')

@section('content')
<style>
  /* Efek hover untuk box */
  .small-box {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
  }
  .small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  /* Tooltip */
  .small-box[data-tooltip] {
    position: relative;
  }
  .small-box[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: -35px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- Materi -->
        <div class="col-lg-4 col-6">
          <a href="{{ url('/materi') }}" style="text-decoration: none; color: inherit;">
            <div class="small-box bg-success" data-tooltip="Lihat semua materi yang tersedia">
              <div class="inner">
                <h3>{{ $totalMateri }}</h3>
                <p>Materi</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-alt"></i>
              </div>
            </div>
          </a>
        </div>

        <!-- Dikerjakan -->
        <div class="col-lg-4 col-6">
          <a href="{{ url('/materi') }}" style="text-decoration: none; color: inherit;">
            <div class="small-box bg-primary" data-tooltip="Lihat materi yang sudah dikerjakan">
              <div class="inner">
                <h3>{{ $materiDikerjakan }}</h3>
                <p>Dikerjakan</p>
              </div>
              <div class="icon">
                <i class="fas fa-check-circle"></i>
              </div>
            </div>
          </a>
        </div>

        <!-- Belum Dikerjakan -->
        <div class="col-lg-4 col-6">
          <a href="{{ url('/materi') }}" style="text-decoration: none; color: inherit;">
            <div class="small-box bg-info" data-tooltip="Lihat materi yang belum dikerjakan">
              <div class="inner">
                <h3>{{ $materiBelumDikerjakan }}</h3>
                <p>Belum Dikerjakan</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
              </div>
            </div>
          </a>
        </div>

        <!-- Chart -->
        <div class="col-12 mt-5">
          <div class="card">
            <div class="card-header bg-dark text-white">
              <h3 class="card-title"><i class="fas fa-chart-bar"></i> Statistik Materi</h3>
            </div>
            <div class="card-body">
              <canvas id="materiChart" height="100"></canvas>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('materiChart').getContext('2d');
  const gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)');
  gradient.addColorStop(1, 'rgba(40, 167, 69, 0.2)');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Total Materi', 'Dikerjakan', 'Belum Dikerjakan'],
      datasets: [{
        label: 'Jumlah',
        data: [{{ $totalMateri }}, {{ $materiDikerjakan }}, {{ $materiBelumDikerjakan }}],
        backgroundColor: [gradient, '#007bff', '#17a2b8'],
        borderWidth: 1,
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#333',
          titleColor: '#fff',
          bodyColor: '#fff',
          cornerRadius: 5
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { precision: 0 }
        }
      }
    }
  });
</script>
@endsection
