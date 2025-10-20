<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;

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

        // Ambil riwayat medis berdasarkan nama pasien
        $records = MedicalRecord::where('patient_name', $user->name)
                    ->orderBy('examination_date', 'desc')
                    ->get();

        return view('patient.records', compact('user', 'records'));
    }
}
