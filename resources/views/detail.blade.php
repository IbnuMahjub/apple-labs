@extends('layouts.main')

@section('content')
<div class="main-content">

  <!-- Post Detail Section -->
  <section class="post-detail py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="card shadow-sm">
            <img src="{{ asset('storage/'.$data->image) }}" class="card-img-top" alt="{{ $data->title }}">
            <div class="card-body">
              <h2 class="card-title">{{ $data->title }}</h2>
              <p class="text-muted">Kategori: {{ $data->category->name }}</p>
              <p class="card-text">{!! $data->description !!}</p> 
            </div>
          </div>
        </div>

        <!-- Sidebar Section (optional) -->
        <div class="col-md-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Kategori Lainnya</h5>
              <ul class="list-group">
                @foreach($categories as $category)
                  <li class="list-group-item">
                    <a href="">{{ $category->name }}</a>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>
@endsection
