<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    $doctors = \App\Models\Doctor::with('user')->get();
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
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'specialization' => 'required|string|max:100',
        'day' => 'required|string|max:50',
        'start_time' => 'required',
        'end_time' => 'required',
        'password' => 'required|string|min:6',
    ]);

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'doctor',
    ]);

    \App\Models\Doctor::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'specialization' => $request->specialization,
        'day' => $request->day,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'status' => $request->status ?? 'active',
    ]);

    return redirect()->route('admin.doctors')->with('success', '✅ Dokter baru berhasil ditambahkan!');
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

    public function indexPatients()
    {
        $patients = User::where('role', 'patient')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function createPatient()
    {
        return view('admin.patients.create');
    }

    public function storePatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $email = strtolower(str_replace(' ', '', $request->name)) . '@patient.klinik.com';

        User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => bcrypt('123123'),
            'role' => 'patient',
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => null,
        ]);

        return redirect()->route('admin.patients')->with('success', 'Pasien berhasil ditambahkan!');
    }

    public function editPatient($id)
    {
        $patient = User::findOrFail($id);
        return view('admin.patients.edit', compact('patient'));
    }

    public function updatePatient(Request $request, $id)
    {
        $patient = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $patient->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.patients')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function deletePatient($id)
    {
        $patient = User::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients')->with('success', 'Pasien dipindahkan ke Trash Bin.');
    }


    public function trash()
    {
        $trashedDoctors = Doctor::onlyTrashed()->get();
        $trashedPatients = User::onlyTrashed()->where('role', 'patient')->get();
        return view('admin.trash', compact('trashedDoctors', 'trashedPatients'));
    }

    public function reports()
    {
        $records = MedicalRecord::with(['doctor', 'patient'])
            ->orderBy('examination_date', 'desc')
            ->get();

        $transactions = Transaction::with(['doctor', 'patient'])
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('admin.reports.medical', compact(
            'records',
            'transactions'
        ));
    }


        public function medicalReports(Request $request)
    {
        $records = MedicalRecord::with(['doctor','patient'])
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('examination_date', [
                    $request->start_date,
                    $request->end_date
                ]);
            })
            ->get();

        return view('admin.reports.medical', compact('records'));
    }

    public function downloadMedicalReport(Request $request)
    {
        $records = MedicalRecord::with(['doctor','patient'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['Tanggal','Pasien','Dokter','Keluhan','Diagnosis','Resep']
        ]);

        $row = 2;
        foreach ($records as $r) {
            $sheet->fromArray([
                $r->examination_date,
                $r->patient->name ?? '-',
                $r->doctor->name ?? '-',
                $r->complaint,
                $r->diagnosis,
                $r->prescription
            ], null, 'A'.$row++);
        }

        $file = storage_path('laporan_rekam_medis.xlsx');
        (new Xlsx($spreadsheet))->save($file);

        return response()->download($file)->deleteFileAfterSend(true);
    }

    public function downloadTransactionReport()
    {
        $transactions = Transaction::with(['patient','doctor'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray([
            ['Tanggal','Pasien','Dokter','Status']
        ]);

        $row = 2;
        foreach ($transactions as $t) {
            $sheet->fromArray([
                $t->transaction_date,
                $t->patient->name ?? '-',
                $t->doctor->name ?? '-',
                $t->status
            ], null, 'A'.$row++);
        }

        $file = storage_path('laporan_transaksi.xlsx');
        (new Xlsx($spreadsheet))->save($file);

        return response()->download($file)->deleteFileAfterSend(true);
    }
}
