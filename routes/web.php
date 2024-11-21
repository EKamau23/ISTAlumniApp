<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppliedJobs;
use App\Models\ist_jobs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return ('welcome');
});

Route::resource('portfolio', PortfolioController::class);
Route::resource('jobs', JobController::class);
Route::get('jobs/{jobId}/delete', [JobController::class, 'destroy']);


Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
Route::resource('permissions', PermissionController::class);
Route::resource('users', UserController::class);
Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
Route::resource('/applicants', AppliedJobs::class);
// Route::get('/appliedjobs/{id}', [AppliedJobs::class, 'show']);


Route::resource('roles', RoleController::class);
Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
Route::post('/apply/{applyId}', action: [ApplicationController::class, 'submitApplication']);




Route::get('jobs/{jobId}/view', function ($id) {

    // Find the job details
   $job = ist_jobs::findOrFail($id);

    // Prepare data for the view
    $user = Auth::user();
    return view('Action.jobs.view-job', [
        'user' => $user->name,
        'title' => $job->job_title,
        'id' => $job->id,
        'name' => $job->job_name,
        'description' => $job->job_description,
        'qualification' => $job->job_qualification,
        'amount' => $job->job_amount,
    ]);
});




Route::get('/dashboard', function () {

    return view('dashboard', [
        'job' => ist_jobs::all()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
