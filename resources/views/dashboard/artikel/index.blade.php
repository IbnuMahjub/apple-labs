@extends('dashboard.layouts.main')

@section('content')

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#propertyModal" id="createPropertyBtn">
       Add Property
    </button>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Judul Artikel</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr id="data-artikel-{{ $item->id }}">
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$item->image)}}" alt="" width="100">
                        </td>
                        <td class="d-flex">
                            <a href="/edit-artikel/{{ $item->id }}" class="btn btn-primary btn-sm me-2">Detail</a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
                                <span data-feather="x-circle"></span> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Setup CSRF token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProperty(id);
            }
        });
    }

    function deleteProperty(id) {
        console.log(id);
        $.ajax({
            url: '{{ url("data-artikel") }}/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',  
            },
            success: function(response) {
                console.log("Response from API:", response);
                if (response.success) {
                    $('#data-artikel-' + id).remove();
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Property has been deleted successfully.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Failed to delete property.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to delete property. Please try again later.',
                    confirmButtonText: 'OK'
                });
            }
        });
    }
</script>
@endsection
