<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\Transaction;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();

    $doctor = Doctor::where('user_id', $user->id)->first();

    $records = MedicalRecord::with('doctor')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('doctor.dashboard', compact('user', 'doctor', 'records'));
}

    public function searchPatient(Request $request)
    {
        $query = $request->input('query');
        $patients = User::where('role', 'patient')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%");
            })
            ->get();

        return response()->json($patients);
    }

    public function showRecords($patient_id)
    {
        $records = MedicalRecord::where('patient_id', $patient_id)->latest()->get();
        $patient = User::find($patient_id);
        return view('doctor.patient_records', compact('patient', 'records'));
    }

    public function storeRecord(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:users,id',
        'complaint' => 'required',
        'diagnosis' => 'required',
        'prescription' => 'required',
        'examination_date' => 'required|date',
    ]);

    $user = Auth::user();
    $doctor = Doctor::where('user_id', $user->id)->first();

    if (!$doctor) {
        return back()->with('error', 'Data dokter tidak ditemukan.');
    }

    MedicalRecord::create([
        'doctor_id' => $doctor->id,
        'patient_id' => $request->patient_id,
        'patient_name' => $request->patient_name,
        'complaint' => $request->complaint,
        'diagnosis' => $request->diagnosis,
        'prescription' => $request->prescription,
        'notes' => $request->notes,
        'examination_date' => $request->examination_date,
    ]);

    return back()->with('success', 'Riwayat medis berhasil ditambahkan!');
}


public function getPatientRecords(Request $request)
{
    $query = $request->input('query');

    $patient = \App\Models\User::where('name', 'LIKE', "%$query%")
        ->orWhere('email', 'LIKE', "%$query%")
        ->where('role', 'patient')
        ->first();

    if (!$patient) {
        return response()->json(['patient' => null, 'records' => []]);
    }

    $records = \App\Models\MedicalRecord::where('patient_id', $patient->id)
        ->with('doctor')
        ->orderBy('examination_date', 'desc')
        ->get();

    return response()->json([
        'patient' => $patient,
        'records' => $records
    ]);
}


public function createRecord($patient_id)
{
    $patient = \App\Models\User::findOrFail($patient_id);
    $records = \App\Models\MedicalRecord::where('patient_id', $patient_id)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('doctor.patient_records', compact('patient', 'records'));
}

public function showSchedule()
{
    $user = auth()->user();
    $doctor = Doctor::where('user_id', $user->id)->first();

    if (!$doctor) {
        return redirect()->route('doctor.dashboard')->with('error', 'Data dokter tidak ditemukan.');
    }

    return view('doctor.schedule', compact('doctor', 'user'));
}

public function updateSchedule(Request $request)
{
    $request->validate([
        'day' => 'required|string|max:50',
        'start_time' => 'required',
        'end_time' => 'required',
        'status' => 'required|in:active,inactive',
    ]);

    $user = auth()->user();
    $doctor = Doctor::where('user_id', $user->id)->first();

    if (!$doctor) {
        return back()->with('error', 'Data dokter tidak ditemukan.');
    }

    $doctor->update([
        'day' => $request->day,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'status' => $request->status,
    ]);

    return redirect()->route('doctor.schedule')->with('success', 'Jadwal berhasil diperbarui.');
}

    public function appointments(Request $request)
    {
        $user = auth()->user();
        $doctor = Doctor::where('user_id', $user->id)->first();

        if (!$doctor) {
            return back()->with('error', 'Data dokter tidak ditemukan.');
        }

        $date = $request->input('date', date('Y-m-d'));

        $appointments = \App\Models\Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $date)
            ->with('patient')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments', 'date'));
    }

    public function complete($id)
{
    $appointment = Appointment::findOrFail($id);

    $appointment->update([
        'status' => 'completed'
    ]);

    Transaction::create([
        'appointment_id' => $appointment->id,
        'patient_id' => $appointment->patient_id,
        'doctor_id' => $appointment->doctor_id,
        'status' => 'paid',
        'transaction_date' => now()->toDateString()
    ]);

    return back()->with('success', 'Appointment selesai & transaksi tercatat');
}



}
