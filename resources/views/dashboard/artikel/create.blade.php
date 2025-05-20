@extends('dashboard.layouts.main')

@section('content')
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4 text-primary">From {{ $title }}</h5>
        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">category</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" data-placeholder="Choose one thing">
                            <option value="">Select category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" {{ old('id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    {{-- <div class="card mb-3">
                        <div class="card-body bg-dark @error('images') is-invalid @enderror">
                            <input id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" name="images[]" multiple>
                        </div>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#image-uploadify').imageuploadify();

        $('#category_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Select Property",
            
        });
        $('#tipe').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Select Tipe",
            
        });

    })
</script>
@endsection
