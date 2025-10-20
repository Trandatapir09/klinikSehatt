@extends('layouts.main')

@section('title', 'Dashboard Dokter - Klinik Sehat')

@section('content')
<div class="container py-4">

  {{-- 🔹 Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary mb-0">Dashboard Dokter</h2>
    <div>
      <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
        <i class="bi bi-house-door"></i> Beranda
      </a>
      <a href="{{ route('doctor.schedule') }}" class="btn btn-primary">
        <i class="bi bi-gear"></i> Atur Jadwal
      </a>
    </div>
  </div>

  {{-- 🩺 Profil Dokter --}}
  <div class="card shadow border-0 mb-4">
    <div class="card-body d-flex align-items-center">

      {{-- Foto Dokter --}}
      <div class="me-4">
        @if(isset($doctor) && $doctor->photo)
          <img src="{{ asset('storage/' . $doctor->photo) }}" 
              class="rounded-circle border shadow-sm"
              alt="Foto Dokter"
              style="width: 120px; height: 120px; object-fit: cover;">
        @else
          <img src="{{ asset('images/default-doctor.png') }}" 
              class="rounded-circle border shadow-sm"
              alt="Default"
              style="width: 120px; height: 120px; object-fit: cover;">
        @endif

      </div>

      {{-- Detail Dokter --}}
      <div class="flex-grow-1">
        <h4 class="mb-1 text-dark">{{ $doctor->name }}</h4>
        <p class="text-muted mb-2"><i class="bi bi-person-badge"></i> {{ $doctor->specialization }}</p>
        <p class="mb-1"><strong>Jadwal:</strong> {{ $doctor->day }} ({{ $doctor->start_time }} - {{ $doctor->end_time }})</p>
        <p class="mb-1"><strong>Status:</strong> 
          @if($doctor->status === 'active')
            <span class="badge bg-success">Aktif</span>
          @else
            <span class="badge bg-secondary">Nonaktif</span>
          @endif
        </p>
      </div>

      {{-- Tombol Edit --}}
      <div>
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
          ✏️ Edit Profil
        </a>
      </div>
    </div>
  </div>

  {{-- 🔍 Cari Pasien --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h5 class="fw-bold text-primary mb-3">
        <i class="bi bi-search"></i> Cari Pasien
      </h5>
      <input type="text" id="search" class="form-control shadow-sm" placeholder="Ketik nama atau email pasien...">
      
      <div id="loading" class="text-muted small mt-2" style="display:none;">
        <i class="bi bi-hourglass-split"></i> Mencari data pasien...
      </div>

      <ul id="results" class="list-group mt-3"></ul>
      <div id="records-container" class="mt-4"></div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let timer = null;

    $('#search').on('keyup', function() {
        clearTimeout(timer);
        const query = $(this).val().trim();

        if (query.length < 2) {
            $('#results').html('');
            $('#records-container').html('');
            $('#loading').hide();
            return;
        }

        timer = setTimeout(() => {
            $('#loading').show();
            console.log('🔍 Mengirim request ke server untuk query:', query);

            $.ajax({
                url: "{{ route('doctor.patient.records') }}",
                type: 'GET',
                dataType: 'json',
                data: { query: query },

                success: function(data) {
                    console.log('✅ Respons diterima dari server:', data);
                    $('#loading').hide();

                    let list = '';
                    if (data.patient) {
                        list = `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                  <strong>${data.patient.name}</strong> 
                                  <small class="text-muted">(${data.patient.email})</small>
                                </div>
                                <a href="/doctor/records/create/${data.patient.id}" 
                                   class="btn btn-sm btn-success">
                                   <i class="bi bi-plus-circle"></i> Tambah Riwayat
                                </a>
                            </li>`;
                    } else {
                        list = '<li class="list-group-item text-muted">Pasien tidak ditemukan</li>';
                    }
                    $('#results').html(list);

                    if (data.records && data.records.length > 0) {
                        let table = `
                            <h5 class="mt-4 text-primary">Riwayat Medis: ${data.patient.name}</h5>
                            <div class="table-responsive">
                              <table class="table table-striped align-middle">
                                <thead class="table-primary text-center">
                                  <tr>
                                    <th>Tanggal</th>
                                    <th>Diagnosa</th>
                                    <th>Resep</th>
                                    <th>Dokter</th>
                                  </tr>
                                </thead>
                                <tbody>`;
                        data.records.forEach(r => {
                            table += `
                              <tr>
                                <td>${r.examination_date}</td>
                                <td>${r.diagnosis}</td>
                                <td>${r.prescription}</td>
                                <td>${r.doctor ? r.doctor.name : '-'}</td>
                              </tr>`;
                        });
                        table += `</tbody></table></div>`;
                        $('#records-container').html(table);
                    } else if (data.patient) {
                        $('#records-container').html('<p class="mt-3 text-muted">Belum ada riwayat medis untuk pasien ini.</p>');
                    }
                },

                error: function(xhr, status, error) {
                    $('#loading').hide();
                    console.error('❌ Error AJAX:', status, error, xhr.responseText);
                    alert('❌ Terjadi kesalahan saat mengambil data pasien.\n' +
                          'Status: ' + status + '\nError: ' + error);
                }
            });
        }, 400);
    });
});
</script>
@endpush

