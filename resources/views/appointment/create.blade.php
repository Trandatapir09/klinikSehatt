@extends('layouts.main')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Pendaftaran Antrian</h2>

    <div class="card shadow p-4">
        <form action="{{ route('appointment.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pilih Dokter</label>
                <select name="doctor_id" id="doctor_select" class="form-select" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->name }} ({{ $doctor->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="doctor_info" class="alert alert-info d-none">
                <h5 id="doc_name"></h5>
                <p><strong>Spesialis:</strong> <span id="doc_spec"></span></p>
                <p><strong>Jadwal:</strong> <span id="doc_day"></span>,
                    <span id="doc_time"></span>
                </p>
                <p><strong>Jumlah Antrian Hari Ini:</strong> <span id="doc_queue"></span></p>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Periksa</label>
                <input type="date" class="form-control" name="appointment_date" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jam Periksa</label>
                <select name="time_range" id="time_select" class="form-select" required>
                <option value="">-- Pilih Jam --</option>
            </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Daftar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let selectedDoctor = null;

document.getElementById('doctor_select').addEventListener('change', function () {
    selectedDoctor = this.value;

    if (!selectedDoctor) return;

    fetch(`/appointment/doctor-info/${selectedDoctor}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('doctor_info').classList.remove('d-none');
            document.getElementById('doc_name').innerText = data.name;
            document.getElementById('doc_spec').innerText = data.specialization;
            document.getElementById('doc_day').innerText = data.day;
            document.getElementById('doc_time').innerText = data.start_time + ' - ' + data.end_time;
            document.getElementById('doc_queue').innerText = "Pilih tanggal untuk melihat antrian";

            loadDoctorTimeOptions(data.start_time, data.end_time);
        });
});

function loadDoctorTimeOptions(start, end) {
    const select = document.getElementById('time_select');
    select.innerHTML = `<option value="">-- Pilih Jam --</option>`;

    let S = parseInt(start.split(":")[0]);
    let E = parseInt(end.split(":")[0]);

    for (let hour = S; hour < E; hour++) {
        let from = (hour < 10 ? "0"+hour : hour) + ":00";
        let to = (hour+1 < 10 ? "0"+(hour+1) : (hour+1)) + ":00";
        let label = `${from} - ${to}`;

        select.innerHTML += `<option value="${label}">${label}</option>`;
    }
}

document.querySelector('input[name="appointment_date"]').addEventListener('change', function () {
    let date = this.value;

    if (!selectedDoctor || !date) return;

    fetch(`/appointment/doctor-queue/${selectedDoctor}/${date}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('doc_queue').innerText =
                data.queue + " pasien terdaftar pada tanggal ini";
        });
});

</script>
@endsection
