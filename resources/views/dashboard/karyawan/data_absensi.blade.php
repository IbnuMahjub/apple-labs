@extends('dashboard.layouts.main')

@section('content')

<div class="card">
    <div class="card-body">
      <h3>Data Absensi Karyawan</h3>
      <p>Berikut adalah data absensi karyawan yang terdaftar.</p>
    </div>
  </div>
  
  <!-- Filter/Search Section -->
  {{-- <div class="card mt-3">
    <div class="card-body">
      <form action="" method="GET">
        <div class="row">
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari Nama Karyawan...">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Cari</button>
          </div>
        </div>
      </form>
    </div>
  </div> --}}
  
  <!-- Absensi Table Section -->
  <div class="card mt-3">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <h4>Daftar Absensi Karyawan</h4>
        <a href="#" class="btn btn-success">Tambah Absensi</a>
      </div>
      <table class="table table-bordered" id="example">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Tanggal Absensi</th>
            <th>Absen Masuk</th>
            <th>Absen Pulang</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->jam_masuk }}</td>
            <td>{{ $item->jam_pulang }}</td>
            <td>
              <a href="#" class="btn btn-warning btn-sm">Edit</a>
              <a href="#" class="btn btn-danger btn-sm">Hapus</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@section('scripts')
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
@endsection

@endsection
