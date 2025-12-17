<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\User;    

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('patient.dashboard', compact('user'));
    }

    public function medicalRecords()
    {
        $user = Auth::user();

        $records = MedicalRecord::where('patient_name', $user->name)
                    ->orderBy('examination_date', 'desc')
                    ->get();

        return view('patient.records', compact('user', 'records'));
    }

     public function index()
    {
        $patients = User::where('role', 'patient')->whereNull('deleted_at')->get();
        return view('admin.patients.index', compact('patients'));
    }

    public function destroy($id)
    {
        $patient = User::findOrFail($id);
        $patient->delete();

        return back()->with('success', 'Pasien berhasil dihapus (soft delete).');
    }

    public function trash()
    {
        $patients = User::onlyTrashed()->where('role', 'patient')->get();
        return view('admin.patients.trash', compact('patients'));
    }

    public function restore($id)
    {
        User::withTrashed()->where('id', $id)->restore();

        return back()->with('success', 'Pasien berhasil dikembalikan!');
    }

    public function forceDelete($id)
    {
        User::withTrashed()->where('id', $id)->forceDelete();

        return back()->with('success', 'Data pasien dihapus permanen!');
    }
}
