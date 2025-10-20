<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalDoctors = Doctor::count();
        $totalPatients = User::where('role', 'patient')->count();
        $totalRecords = MedicalRecord::count();

        return view('admin.dashboard', compact('totalDoctors', 'totalPatients', 'totalRecords'));
    }

    public function indexDoctors()
{
    $doctors = \App\Models\User::where('role', 'doctor')->get();
    return view('admin.doctors.index', compact('doctors'));
}

public function createDoctor()
{
    $users = User::where('role', 'doctor')->get();
    return view('admin.doctors.create');
}

public function storeDoctor(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users',
        'specialization' => 'required|string|max:100',
        'day' => 'required|string|max:50',
        'start_time' => 'required',
        'end_time' => 'required',
        'password' => 'required|string|min:6',
    ]);

    // Simpan ke tabel users
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'doctor',
    ]);

    // Simpan ke tabel doctor
    \App\Models\Doctor::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'specialization' => $request->specialization,
        'day' => $request->day,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'status' => 'active',
    ]);

    return redirect()->route('admin.doctors')->with('success', 'Dokter berhasil ditambahkan!');
}

public function editDoctor($id)
{
    $doctor = \App\Models\Doctor::findOrFail($id);
    return view('admin.doctors.edit', compact('doctor'));
}

public function updateDoctor(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'specialization' => 'required|string|max:100',
        'day' => 'required|string|max:50',
        'start_time' => 'required',
        'end_time' => 'required',
        'status' => 'required|in:active,inactive',
    ]);

    $doctor = \App\Models\Doctor::findOrFail($id);
    $doctor->update($request->all());

    // Update juga data di tabel users
    $user = \App\Models\User::find($doctor->user_id);
    $user->update(['name' => $request->name]);

    return redirect()->route('admin.doctors')->with('success', 'Data dokter berhasil diperbarui!');
}

public function deleteDoctor($id)
{
    $doctor = \App\Models\Doctor::findOrFail($id);
    $doctor->delete();

    // Soft delete pada tabel user
    $user = \App\Models\User::find($doctor->user_id);
    if ($user) $user->delete();

    return back()->with('success', 'Dokter berhasil dihapus ke Trash Bin.');
}


    public function doctors()
    {
        $doctors = Doctor::all();
        return view('admin.doctors', compact('doctors'));
    }

    public function patients()
    {
        $patients = User::where('role', 'patient')->get();
        return view('admin.patients', compact('patients'));
    }

    public function reports()
    {
        $records = MedicalRecord::with(['doctor', 'patient'])->latest()->get();
        return view('admin.reports', compact('records'));
    }

    public function trash()
    {
        $trashedDoctors = Doctor::onlyTrashed()->get();
        $trashedPatients = User::onlyTrashed()->where('role', 'patient')->get();
        return view('admin.trash', compact('trashedDoctors', 'trashedPatients'));
    }
}
