<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\MenusController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\ArticlesController;
use App\Http\Controllers\Admin\SlidersController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\SocialsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\ConvocationsController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GlobalSearchController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});

Route::get('students/certificate', [StudentController::class,'certificate']);



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resources([
        'permissions' => PermissionsController::class,
        'roles' => RolesController::class,
        'users' => UsersController::class,
        'faculties' => FacultyController::class,
        'convocations' => ConvocationsController::class,
        'programs' => ProgramsController::class,
        'students' => StudentController::class,
    ]);


    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class,'massDestroy'])->name('permissions.massDestroy');
    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    // Users
    Route::delete('users/destroy', [UsersController::class,'massDestroy'])->name('users.massDestroy');
    // Audit Logs
    Route::resource('audit-logs', AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
    //    Route::resources(['permissions' => SettingsController::class],['except' => ['create', 'store', 'show', 'destroy']]);
    Route::post('settings/media', [SettingsController::class, 'storeMedia'])->name('settings.storeMedia');
    Route::post('settings/ckmedia', [SettingsController::class, 'storeCKEditorImages'])->name('settings.storeCKEditorImages');
    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Faculty
    Route::delete('faculties/destroy', [FacultyController::class,'massDestroy'])->name('faculties.massDestroy');

    // Convocations
    Route::delete('convocations/destroy', [ConvocationsController::class,'@massDestroy'])->name('convocations.massDestroy');
    Route::post('convocations/media', [ConvocationsController::class,'storeMedia'])->name('convocations.storeMedia');
    Route::post('convocations/ckmedia', [ConvocationsController::class,'storeCKEditorImages'])->name('convocations.storeCKEditorImages');
    // Programs
    Route::delete('programs/destroy', [ProgramsController::class,'massDestroy'])->name('programs.massDestroy');

    // Student
    Route::delete('students/destroy', [StudentController::class,'massDestroy'])->name('students.massDestroy');

    Route::get('global-search', [GlobalSearchController::class,'search'])->name('globalSearch');
});


Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class,'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class,'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class,'updateProfile'])->name('password.updateProfile');
        Route::post('profile/destroy', [ChangePasswordController::class,'destroy'])->name('password.destroyProfile');
        Route::get('/edit',[ProfileController::class,'edit'])->name('edit');
        Route::post('/edit',[ProfileController::class,'updateProfile'])->name('updateProfile');
    }
});








Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/htest',[App\Http\Controllers\HomeController::class,'htest'])->name('htest');
