<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Transaction;
use app\Models\Appointment;
use App\Http\Controllers\AdminController;
use Mews\Captcha\Facades\Captcha;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $doctors = Doctor::where('status', 'active')->get();
    return view('welcome', compact('doctors'));
});

Route::get('/appointment/doctor-info/{id}', [AppointmentController::class, 'doctorInfo']);
Route::get('/appointment/doctor-queue/{doctorId}/{date}', [AppointmentController::class, 'getQueueByDate']);
Route::get('/appointment/doctor-times/{id}', [AppointmentController::class, 'getDoctorTimes']);

Route::get('/test-excel', function () {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Test Berhasil!');

    $writer = new Xlsx($spreadsheet);

    // simpan ke output buffer
    $fileName = "uji_excel.xlsx";

    // header agar browser download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"{$fileName}\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
});

Route::get('/captcha/{config?}', function ($config = 'default') {
    return Captcha::create($config);
})->name('captcha');

Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_img()]);
});

Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Keamanan
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

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');


//Dokter
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
    Route::get('/doctor/appointments', [AppointmentController::class, 'doctorView'])->name('doctor.appointments');
    Route::post('/doctor/appointments/update/{id}', [AppointmentController::class, 'updateStatus'])->name('doctor.appointments.update');

    Route::post('/doctor/appointment/{id}/complete', [DoctorController::class, 'complete'])->name('doctor.appointment.complete');
});


//Pasien
Route::middleware(['auth'])->group(function () {
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/records', [PatientController::class, 'medicalRecords'])->name('patient.records');
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment/store', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/history', [AppointmentController::class, 'history'])->name('appointment.history');
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
    Route::get('/admin/patients', [AdminController::class, 'indexPatients'])->name('admin.patients');
    Route::get('/admin/patients/create', [AdminController::class, 'createPatient'])->name('admin.patients.create');
    Route::post('/admin/patients/store', [AdminController::class, 'storePatient'])->name('admin.patients.store');
    Route::get('/admin/patients/edit/{id}', [AdminController::class, 'editPatient'])->name('admin.patients.edit');
    Route::put('/admin/patients/update/{id}', [AdminController::class, 'updatePatient'])->name('admin.patients.update');
    Route::delete('/admin/patients/delete/{id}', [AdminController::class, 'deletePatient'])->name('admin.patients.delete');

    // Laporan
Route::get('/admin/reports',
    [AdminController::class, 'reports']
)->name('admin.reports');
    
    Route::get('/reports/medical', [AdminController::class, 'medicalReports'])
        ->name('admin.reports.medical');

    Route::get('/reports/medical/download', [AdminController::class, 'downloadMedicalReport'])
        ->name('admin.reports.medical.download');

    // ===== TRANSACTIONS =====
    Route::get('/reports/transactions', [AdminController::class, 'transactionReports'])
        ->name('admin.reports.transactions');

    Route::get('/reports/transactions/download', [AdminController::class, 'downloadTransactionReport'])
        ->name('admin.reports.transactions.download');     

    // Trash bin
    Route::get('/admin/patients/trash', [PatientController::class, 'trash'])->name('admin.patients.trash');
    Route::post('/admin/patients/restore/{id}', [PatientController::class, 'restore'])->name('admin.patients.restore');
    Route::delete('/admin/patients/force-delete/{id}', [PatientController::class, 'forceDelete'])->name('admin.patients.forceDelete');

    Route::get('/admin/appointments', [AppointmentController::class, 'adminView'])->name('admin.appointments');
    Route::post('/admin/appointments/update/{id}', [AppointmentController::class, 'adminUpdate'])->name('admin.appointments.update');
    Route::delete('/admin/appointments/delete/{id}', [AppointmentController::class, 'adminDelete'])->name('admin.appointments.delete');
    

});