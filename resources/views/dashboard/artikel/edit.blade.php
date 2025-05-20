@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4 text-primary">Edit Artikel</h5>
        <form action="{{ route('artikel.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Untuk melakukan update -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('category_id', $post->category_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Menampilkan gambar yang ada -->
                    <div class="mb-3">
                        <label for="current_image" class="form-label">Current Image</label>
                        <br>
                        @if ($post->image)
                            <img src="{{ Storage::url($post->image) }}" alt="Current Image" class="img-thumbnail" width="200">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>

                    <!-- Input file untuk mengganti gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
