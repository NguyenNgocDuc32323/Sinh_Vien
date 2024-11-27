<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Teacher\ManagerTeacherController;
use App\Http\Controllers\Admin\Teacher\TeacherController as TeacherTeacherController;
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
use App\Models\Teacher;
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
    //student
    Route::get('/delete-student/{id}',[AdminController::class,'delete_student'])->name('delete-student');
    Route::get('/create-student',[AdminController::class,'create_student'])->name('create-student');
    Route::post('/create-student-post',[AdminController::class,'create_student_post'])->name('create-student-post');
    Route::get('/update-student/{id}',[AdminController::class,'update_student'])->name('update-student');
    Route::post('/update-student-post/{id}',[AdminController::class,'update_student_post'])->name('update-student-post');
    Route::post('/student-update-password/{id}',[AdminController::class,'updatePasswordPost'])->name('student-update-password');
    Route::get('/student-search',[AdminController::class,'student_search'])->name('student-search');
    Route::post('/update-password-student/{id}',[AdminController::class,'updatePassword'])->name('update-password-student');
    //teacher
    Route::get('/manage-teacher',[ManagerTeacherController::class,'index'])->name('manage-teacher');
    Route::get('/teacher-search',[ManagerTeacherController::class,'teacher_search'])->name('teacher-search');
    Route::get('/delete-teacher/{id}',[ManagerTeacherController::class,'delete_teacher'])->name('delete-teacher');
    Route::get('/create-teacher',[ManagerTeacherController::class,'create_teacher'])->name('create-teacher');
    Route::post('/create-teacher-post',[ManagerTeacherController::class,'create_teacher_post'])->name('create-teacher-post');
    Route::get('/update-teacher/{id}',[ManagerTeacherController::class,'update_teacher'])->name('update-teacher');
    Route::post('/update-teacher-post/{id}',[ManagerTeacherController::class,'update_teacher_post'])->name('update-teacher-post');
    Route::post('/update-teacher-password/{id}',[ManagerTeacherController::class,'updatePassword'])->name('update-teacher-password');
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
    Route::get('/create-scores-get',[TeacherController::class,'create_scores_get'])->name('create-scores-get');
    Route::post('/create-scores-post',[TeacherController::class,'create_scores_post'])->name('create-scores-post');
    Route::get('/user-profile/{id}',[TeacherController::class,'teacher_profile'])->name('teacher-profile');
    Route::get('/logout',[LogoutController::class,'logout'])->name('logout');
});
