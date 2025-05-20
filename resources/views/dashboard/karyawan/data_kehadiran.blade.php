@extends('dashboard.layouts.main')

@section('content')

<div class="card">
  <div class="card-body">
    <h3>Data Absensi Karyawan</h3>
    <p>Berikut adalah data absensi karyawan yang terdaftar.</p>

    <form method="GET" action="{{ route('karyawan.kehadiran') }}">
      <div class="row">
        <div class="col-md-3">
          <select name="bulan" class="form-control">
            @for($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" {{ $i == request()->bulan ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
              </option>
            @endfor
          </select>
        </div>
        <div class="col-md-3">
          <select name="tahun" class="form-control">
            @for($i = 2020; $i <= 2030; $i++) <!-- Sesuaikan tahun sesuai kebutuhan -->
              <option value="{{ $i }}" {{ $i == request()->tahun ? 'selected' : '' }}>
                {{ $i }}
              </option>
            @endfor
          </select>
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
      </div>
    </form>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Hari</th>
          <th>Status</th>
          <th>Jam Masuk</th>
          <th>Jam Pulang</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($hariDalamSebulan as $index => $data)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($data['tanggal'])->format('d-m-Y') }}</td>
            <td>{{ $data['hari'] }}</td>
            <td>{{ $data['status'] }}</td>
            <td>{{ $data['jam_masuk'] }}</td>
            <td>{{ $data['jam_pulang'] }}</td>
          </tr>
        @endforeach   
      </tbody>
    </table>
  </div>
</div>

@endsection
