<?php

use App\Http\Controllers\Admin\VendorTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ticket_import_Controller;
use App\Http\Controllers\DashboardController;
// AuthController
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/debug-session', function () {
    return session()->all();
});
Route::middleware(['auth'])->group(function () {
    Route::get('/login', function () {
        return view('dashboard/index4');
    });
  

});
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/log', [DashboardController::class, 'logout'])->name('logout.test');
// Route::get('/logoutt', [LoginController::class, 'logout'])->name('logout.test');
// Route::post('/logoutt', function () {
//     dd("Test route reached!"); // Debugging
// });


Route::middleware(['auth'])->group(function () {
    // Route::get('/index', function () {
    //     return view('dashboard/index2');
    // });
    // Route::get('/import', function () {
    //     return view('excel');
    // });
    Route::get('/index', function () {
        return view('dashboard/index4');
    });
    Route::get('/', function () {
        return view('dashboard/index4');
    });
    Route::get('/ticket_filter', function () {
        // return view('Tickets/ticket_filter');
        return view('Tickets/tk_filter');
    
    });
    Route::get('/profile', function () {
        return view('profile');
    });
        // Route::get('/index', function () {
        //     return view('dashboard/index4');
        // });
    Route::get('/vendor-types', function () {
        $types = DB::table('types')->select('company_id', 'title', 'parent_id', 'active')->get();
        return view('types/index', compact('types'));
    });
    Route::get('/status', function () {
        return view('status/index');
    });

    Route::get('/priority', function () {
        return view('priority/index');
    });
    Route::get('/impact', function () {
        return view('impact/index');
    });
    Route::get('/groups', function () {
        return view('groups/index');
    });
    Route::get('/domain', function () {
        return view('domain/index');
    });
    Route::get('/bu', function () {
        return view('bu/index');
    });
    Route::get('/customer', function () {
        return view('um/customer');
    });
    // Route::resource('groups', 'GroupController');
    Route::get('/vendor', function () {
        return view('vendor/index');
    });

    Route::get('/Subscription', function () {
        return view('Subscription/index');
    });
    Route::get('/Tickets', function () {
        return view('Tickets/index');
    });
    Route::get('/Tickets/{id}', function () {
        return view('Tickets/new');
    });
    // Route::get('/Permission', function () {
    //     return view('um/permission');
    // });
    // Route::get('/role', function () {
    //     return view('um/role');
    // });
    Route::get('/user', function () {
        return view('um/user');
    });

    Route::get('/designation', function () {
        return view('um/designation');
    });
    Route::get('/Company', function () {
        return view('company/index');
    });

    Route::get('/company_profile', function () {
        return view('company_profile');
    });
    Route::get('/chat', function () {
        return view('chat/index');
    });
    Route::get('/group', function () {
        return view('groups/group');
    });
    // Route::get('/ticket_filter', function () {
    //     return view('Tickets/ticket_filter');
    // });
  
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::post('recover_login/generate_otp', [App\Http\Controllers\AuthController::class, 'send_otp'])->name('generate.otp');

Route::post('tickets', [App\Http\Controllers\Ticket_import_Controller::class, 'Tickets'])->name('tickets');
Route::post('bu', [App\Http\Controllers\Ticket_import_Controller::class, 'BU'])->name('bu_import');
Route::post('user', [App\Http\Controllers\Ticket_import_Controller::class, 'Users'])->name('users');
Route::post('group', [App\Http\Controllers\Ticket_import_Controller::class, 'Group'])->name('group');
Route::get('/forgot_password', function () {
    return view('auth/forgot-password');
});

Route::get('/reset_password/{email}', function () {
    return view('auth/reset_password');
});
Route::get('/recover_login', function () {
    // resources/views/auth/reset_password.blade.php
    return view('auth/forgot-password');
});
Route::get('/otp/input', function () {
    // resources/views/auth/reset_password.blade.php
    return view('auth/otp-verification');
});
// Route::get('/upload-form', [Ticket_import_Controller::class, 'showForm'])->name('upload.form');
// Route::post('/upload', [Ticket_import_Controller::class, 'upload']);

// Route::get('/excel',function(){
//     return view('excel');
// });
// Route::excel('export',[\App\Http\Controllers\Ticket_import_Controller::class,'export_excel'])->name('export');

Route::get('/create-group', [App\Http\Controllers\GroupController::class, 'showCreateGroupForm'])->name('group.create_form');
Route::post('/create-and-add-users', [App\Http\Controllers\GroupController::class, 'createAndAddUsers'])->name('group.create_and_add_users');

Route::get('/add-user-to-group', [App\Http\Controllers\GroupController::class, 'showAddUserToGroupForm'])->name('group.add_user_form');
Route::post('/add-user-to-group', [App\Http\Controllers\GroupController::class, 'addUserToGroup'])->name('group.add_user');
Route::post('/message/send', 'MessageController@sendMessage');
Route::get('/message/group/{groupId}', 'MessageController@getGroupMessages');
Auth::routes();
Route::post('/otp/verification', [App\Http\Controllers\AuthController::class, 'verify_otp'])->name("password.otp.verify");



Route::post('/upload/image', [App\Http\Controllers\DashboardController::class, 'uploadimage']);


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
