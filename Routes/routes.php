<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\{UserController,
                                  RegistrationController,
                                  LoginController,
                                  RoleController};
Route::group(['prefix'=> 'api/','middleware' => ['api']], function() {
    Route::group(['namespace' => 'App\Modules\Auth\Controllers', 'prefix' => 'users', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/', [UserController::class, 'users'])->name('users')->middleware(['ability:users-list']);
        Route::get('/{id}', [UserController::class, 'user'])->name('user')->middleware(['ability:user-item']);
        Route::post('/', [UserController::class, 'userStore'])->name('userStore')->middleware(['ability:user-create']);
        Route::put('/{id}', [UserController::class, 'userStore'])->name('userStoreUpdate')->middleware(['ability:user-update']);
        Route::get('/select/options', [UserController::class, 'usersOfRole'])->name('usersOfRole')->middleware(['ability:user-item']);
    });

    Route::group(['namespace' => 'App\Modules\Auth\Controllers', 'prefix' => 'roles', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/select/options', [RoleController::class, 'selectOptionsRoles'])->name('options_roles')->middleware(['ability:roles-list']);
        Route::get('/', [RoleController::class, 'getRoles'])->name('roles')->middleware(['ability:roles-list']);
        Route::get('/{id}', [RoleController::class, 'getRole'])->name('role')->middleware(['ability:role-item']);
        Route::post('/', [RoleController::class, 'storeRole'])->name('storeRole')->middleware(['ability:role-create']);
        Route::put('/{id}', [RoleController::class, 'storeRole'])->name('storeRoleUpdate')->middleware(['ability:role-update']);
    });

    Route::group(['namespace' => 'App\Modules\Auth\Controllers', 'prefix' => 'permissions', 'middleware' => ['auth:sanctum']], function () {
        Route::get('/', [RoleController::class, 'getPermissions'])->name('permissions')->middleware(['ability:permissions-list']);
    });


    Route::patch('/change/fast/code', [UserController::class, 'addToUserFastCode'])->name('addToUserFastCode');
    Route::post('/registration', [RegistrationController::class, 'registration'])->name('registration');
    Route::post('/registration/parent', [RegistrationController::class, 'registrationParent'])->name('registrationParent');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/find/mobile', [LoginController::class, 'findMobile'])->name('findMobile');
    Route::get('/find/iin', [UserController::class, 'findIIn'])->name('findIIn');
    Route::post('/refresh-token', [LoginController::class, 'refreshToken'])->name('refreshToken')->middleware(['auth:sanctum',
        'ability:issue-access-token']);
});
