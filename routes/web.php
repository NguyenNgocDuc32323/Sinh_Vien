<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\User\ManageUserController;
use App\Http\Controllers\Admin\User\UpdateUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get ('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login-post');
Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('register-post');
Route::get('/forgot-password',[ForgotPasswordController::class,'index'])->name('forgot-password');
Route::post('/forgot-password',[ForgotPasswordController::class,'forgotPassword'])->name('forgot-password-post');
Route::get('/reset-password',[ResetPasswordController::class,'index'])->name('reset-password');
Route::post('/reset-password',[ResetPasswordController::class,'resetPassword'])->name('reset-password-post');
Route::post('/upload-image', [HomeController::class, 'uploadImage'])->name('upload-image');

Route::prefix('admin')->middleware('admin')->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('admin');
    Route::get('/chart-data', [AdminController::class, 'getChartData']);
    //user
    Route::get('/manage-user',[ManageUserController::class,'index'])->name('manage-user');
    Route::get('/delete-user/{id}', [ManageUserController::class, 'delete'])->name('delete-user');
    Route::get('/user-search', [ManageUserController::class, 'search'])->name('user-search');
    Route::get('/update-user/{id}',[UpdateUserController::class,'updateInfor'])->name('update-user');
    Route::post('/update-user/{id}',[UpdateUserController::class,'updateInforPost'])->name('update-user-post');
    Route::post('/update-password/{id}', [UpdateUserController::class, 'updatePassword'])->name('update-password');
    
});
Route::middleware(['auth','remember'])->group(function () {
    //student
    Route::get('student-index/{id}',[StudentController::class, 'index'])->name('student-index');
    Route::get('/student-profile/{id}',[StudentController::class, 'student_profile'])->name('student-profile');
    Route::get('/student-scores',[StudentController::class,'manage_scores'])->name('student-scores');
    Route::get('/user-profile-edit/{id}',[StudentController::class,'edit'])->name('user-profile-edit');
    Route::post('/user-profile-edit-post/{id}',action: [StudentController::class,'updateInforPost'])->name('user-profile-edit-post');
    Route::post('/user-edit-password-post/{id}',[StudentController::class,'updatePasswordPost'])->name('user-edit-password-post');
    //teacher
    Route::get('/teacher-index/{id}',[TeacherController::class,'index'])->name('teacher-index');
    Route::get('/manage-student-scores',[TeacherController::class,'student_scores'])->name('manage-student-scores');
    Route::get('/update-scores/{studentId}/{semesterId}',[TeacherController::class,'update_scores'])->name('update-scores');
    Route::post('/update-scores/{studentId}/{semesterId}', [TeacherController::class, 'show_selected_score'])->name('update-scores.submit');
    Route::post('/update-scores/{studentId}/{semesterId}/update', [TeacherController::class, 'update_score'])->name('update-scores.update');
    Route::get('/delete-scores/{studentId}/{semesterId}', [TeacherController::class, 'delete_scores_get'])->name('delete-scores');
    Route::get('/user-profile/{id}',[TeacherController::class,'teacher_profile'])->name('teacher-profile');
    Route::get('/logout',[LogoutController::class,'logout'])->name('logout');
});
