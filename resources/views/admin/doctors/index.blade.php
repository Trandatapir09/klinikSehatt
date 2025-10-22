@extends('layouts.main')

@section('title', 'Daftar Dokter - Klinik Sehat')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0">
      👨‍⚕️ Daftar Dokter
    </h2>
    <div>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
      </a>
      <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Dokter
      </a>
    </div>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body">
      @if($doctors->count() > 0)
        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead class="table-primary text-center">
              <tr>
                <th>Nama</th>
                <th>Spesialisasi</th>
                <th>Hari Praktek</th>
                <th>Jam</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @foreach($doctors as $doctor)
                <tr>
                  <td>{{ $doctor->name }}</td>
                  <td>{{ $doctor->specialization }}</td>
                  <td>{{ $doctor->day }}</td>
                  <td>{{ $doctor->start_time }} - {{ $doctor->end_time }}</td>
                  <td>
                    @if($doctor->status == 'active')
                      <span class="badge bg-success">Aktif</span>
                    @else
                      <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-warning">
                      <i class="bi bi-pencil-square">Ubah</i>
                    </a>
                    <form action="{{ route('admin.doctors.delete', $doctor->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokter ini?')">
                        <i class="bi bi-trash">Hapus</i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <p class="text-center text-muted mb-0">Belum ada data dokter.</p>
      @endif
    </div>
  </div>
</div>
@endsection
