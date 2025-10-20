<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $doctors = Doctor::where('status', 'active')->get();
    return view('welcome', compact('doctors'));
});

// 🔐 Autentikasi
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect('/home');
    }
    return view('auth.register');
})->name('register.form');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// 🏡 Halaman Setelah Login
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');


// 🩺 Area Dokter
Route::middleware(['auth'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/search', [DoctorController::class, 'searchPatient'])->name('doctor.search');
    Route::get('/doctor/patient/records', [DoctorController::class, 'getPatientRecords'])
    ->name('doctor.patient.records');
    Route::post('/doctor/record/store', [DoctorController::class, 'storeRecord'])->name('doctor.record.store');
    Route::post('/doctor/record', [DoctorController::class, 'storeRecord'])->name('doctor.record.store');
    Route::get('/doctor/records/create/{patient_id}', [DoctorController::class, 'createRecord'])->name('doctor.record.create');
    Route::get('/doctor/schedule', [DoctorController::class, 'showSchedule'])->name('doctor.schedule');
    Route::post('/doctor/schedule/update', [DoctorController::class, 'updateSchedule'])->name('doctor.schedule.update');
    //profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    

});


// 👩‍⚕️ Area Pasien
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/records', [PatientController::class, 'medicalRecords'])->name('patient.records');
});

Route::get('/dashboard/redirect', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'doctor':
            return redirect()->route('doctor.dashboard');
        case 'patient':
            return redirect()->route('patient.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard'); // jika kamu punya admin
        default:
            return redirect()->route('home');
    }
})->name('dashboard.redirect');

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Dokter
    Route::get('/admin/doctors', [AdminController::class, 'indexDoctors'])->name('admin.doctors');
    Route::get('/admin/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('/admin/doctors/store', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::get('/admin/doctors/edit/{id}', [AdminController::class, 'editDoctor'])->name('admin.doctors.edit');
    Route::put('/admin/doctors/update/{id}', [AdminController::class, 'updateDoctor'])->name('admin.doctors.update');
    Route::delete('/admin/doctors/delete/{id}', [AdminController::class, 'deleteDoctor'])->name('admin.doctors.delete');

    // Data pasien
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');

    // Laporan
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

    // Trash bin
    Route::get('/admin/trash', [AdminController::class, 'trash'])->name('admin.trash');

});
