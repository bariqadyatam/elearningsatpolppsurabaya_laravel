@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="mb-3 text-primary">
                <i class="fas fa-question-circle"></i> {{ $title }}: <span class="text-dark">{{ $materi->judul }}</span>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <a href="{{ route('materi.show', $materi->id) }}" class="btn btn-outline-primary mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke Materi
        </a>

        <form id="quizForm" action="{{ route('quiz.submit', $test->id) }}" method="POST">
            @csrf

            @foreach($quiz as $q)
                <div class="card shadow-sm border-left-primary mb-4 question" 
                     style="display: none;" 
                     data-id="{{ $loop->index }}" 
                     data-durasi="{{ $q->durasi }}">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <span class="badge badge-primary">{{ $loop->iteration }}</span>
                            {{ $q->pertanyaan }}
                        </h5>
                        <span class="float-right text-danger">Sisa Waktu: <span class="timer">--</span> detik</span>
                    </div>
                    <div class="card-body">
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="q{{ $q->id }}a" name="jawaban[{{ $q->id }}]" value="A" class="custom-control-input">
                            <label class="custom-control-label" for="q{{ $q->id }}a">A. {{ $q->opsi_a }}</label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="q{{ $q->id }}b" name="jawaban[{{ $q->id }}]" value="B" class="custom-control-input">
                            <label class="custom-control-label" for="q{{ $q->id }}b">B. {{ $q->opsi_b }}</label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="q{{ $q->id }}c" name="jawaban[{{ $q->id }}]" value="C" class="custom-control-input">
                            <label class="custom-control-label" for="q{{ $q->id }}c">C. {{ $q->opsi_c }}</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="q{{ $q->id }}d" name="jawaban[{{ $q->id }}]" value="D" class="custom-control-input">
                            <label class="custom-control-label" for="q{{ $q->id }}d">D. {{ $q->opsi_d }}</label>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" class="btn btn-primary nextBtn">Lanjut</button>
                    </div>
                </div>
            @endforeach

            <div class="text-center" id="submitArea" style="display: none;">
                <button class="btn btn-lg btn-success px-4">
                    <i class="fas fa-paper-plane"></i> Kumpulkan Jawaban
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    let current = 0;
    let total = $(".question").length;
    let timer;

    function showQuestion(index) {
        $(".question").hide();
        let $q = $(".question[data-id='" + index + "']");
        $q.show();

        let duration = parseInt($q.data("durasi")) || 30; // default 30 detik jika null
        startTimer(index, duration);
    }

    function startTimer(index, duration) {
        clearInterval(timer);
        let timeLeft = duration;
        let $timer = $(".question[data-id='" + index + "']").find(".timer");
        $timer.text(timeLeft);

        timer = setInterval(function(){
            timeLeft--;
            $timer.text(timeLeft);

            if(timeLeft <= 0) {
                clearInterval(timer);
                nextQuestion();
            }
        }, 1000);
    }

    function nextQuestion(){
        current++;
        if(current < total){
            showQuestion(current);
        } else {
            $(".question").hide();
            $("#submitArea").show();
        }
    }

    $(".nextBtn").click(function(){
        nextQuestion();
    });

    // mulai dari soal pertama
    showQuestion(current);
});
</script>
@endsection
