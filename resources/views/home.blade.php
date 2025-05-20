@extends('layouts.main')

@section('content')
<div class="main-content">

  <!-- Marquee Section -->
  <div class="bg-dark text-white py-2">
    <marquee behavior="scroll" direction="left">🍏 Temukan Inovasi Teknologi Terkini | Solusi Cerdas untuk Masa Depan | Eksplorasi Sekarang! 🚀</marquee>
  </div>

  <!-- Blog Post Section -->
  <section class="blog-posts py-5">
    <div class="container">
      <div class="row">
        <!-- Displaying Blog Posts -->
        @foreach($data as $post)
        <div class="col-md-4 mb-4">
          <div class="card shadow-sm">
            <img src="{{ asset('storage/'.$post->image) }}" class="card-img-top" alt="{{ $post->title }}">
            <div class="card-body">
              <h5 class="card-title">{{ $post->title }}</h5>
              <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
              <a href="/detail/{{ $post->slug }}" class="btn btn-primary">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

</div>
@endsection
