<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class AppointmentController extends Controller
{
    public function create()
    {
        $doctors = Doctor::where('status', 'active')->get();
        return view('appointment.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        $doctor = Doctor::find($request->doctor_id);

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'appointment_date' => $request->appointment_date,
            'time_range' => $doctor->start_time . " - " . $doctor->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('appointment.history')
                         ->with('success', 'Antrian berhasil dibuat.');
    }

    public function history()
    {
        $appointments = Appointment::where('patient_id', Auth::id())->get();
        return view('appointment.history', compact('appointments'));
    }

    public function doctorView()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        return view('doctor.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,in-progress,completed',
    ]);

    $appointment = Appointment::findOrFail($id);

    // Update status appointment
    $appointment->status = $request->status;
    $appointment->save();

    // JIKA STATUS SELESAI → SIMPAN KE TRANSAKSI
    if ($request->status === 'completed') {

        // Cegah double transaksi
        $exists = \App\Models\Transaction::where('appointment_id', $appointment->id)->exists();

        if (!$exists) {
            \App\Models\Transaction::create([
                'appointment_id'   => $appointment->id,
                'patient_id'       => $appointment->patient_id,
                'doctor_id'        => $appointment->doctor_id,
                'status'           => 'completed',
                'transaction_date' => now(),
            ]);
        }
    }

    return back()->with('success', 'Status berhasil diperbarui');
}


    public function adminView()
    {
        $appointments = Appointment::with('patient', 'doctor')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return back()->with('success', 'Antrian diperbarui');
    }

    public function adminDelete($id)
    {
        Appointment::destroy($id);

        return back()->with('success', 'Antrian dihapus');
    }

    public function doctorInfo($id)
{
    $doctor = Doctor::findOrFail($id);

    // Hitung jumlah antrian hari ini
    $today = now()->format('Y-m-d');

    $queue = Appointment::where('doctor_id', $id)
                ->where('appointment_date', $today)
                ->count();

    return response()->json([
        'name' => $doctor->name,
        'specialization' => $doctor->specialization,
        'day' => $doctor->day,
        'start_time' => $doctor->start_time,
        'end_time' => $doctor->end_time,
        'queue' => $queue
    ]);
}

    public function getQueueByDate($doctorId, $date)
    {
        $count = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->count();

        return response()->json([
            'queue' => $count
        ]);
    }

    public function getDoctorTimes($id)
    {
        $doctor = Doctor::find($id);

        return response()->json([
            'start_time' => $doctor->start_time,
            'end_time' => $doctor->end_time,
        ]);
    }

}
