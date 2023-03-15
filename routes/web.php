<?php

use Illuminate\Support\Facades\Route;

// imports theme
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\LayoutSchemeController;
use App\Http\Controllers\ColorSchemeController;

// imports auth
use App\Http\Controllers\Auth\ {
  AuthController,
};

// imports general controllers
use App\Http\Controllers\ {
  CountyController,
  ZipCodeController,
};

// imports admin
use App\Http\Controllers\Admin\ {
  AdminAuthController,
  AdminUserController,
  AdminHomeController,
  AdminSystemController,
  AdminCompanyController,
  AdminPermissionController,
  AdminUserProfileController,
  AdminCompanyGroupController,
};

// imports revenda
use App\Http\Controllers\Revenda\ {
  RevendaHomeController,
  RevendaUserController,
  RevendaSystemController,
  RevendaCompanyController,
  RevendaPermissionController,
  RevendaUserProfileController,
};

// themes route
  Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
  Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');
  Route::get('layout-scheme-switcher/{layout_scheme}', [LayoutSchemeController::class, 'switch'])->name('layout-scheme-switcher');
//---

// admin authentication routes
  // admin
    Route::get('admin', [AdminAuthController::class, 'index'])->name('admin.auth.index');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.auth.login');
  //---

  // system
    Route::get('/', [AuthController::class, 'index'])->name('auth.index');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
  //---
//---

// authenticated routes
  Route::middleware('auth')->group(function() {
    // admin routes
      Route::prefix('admin')->group(function() {
        // routes without permission
          Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');
          Route::get('/home', [AdminHomeController::class, 'index'])->name('admin.home.index');
        //---

        // user profile
          Route::get('/userProfile', [AdminUserProfileController::class, 'index'])->name('admin.userProfiles.index');
          Route::put('/userProfile', [AdminUserProfileController::class, 'update'])->name('admin.userProfiles.update');
        //---

        // records route
          Route::get('/companyGroups/create', [AdminCompanyGroupController::class, 'create'])->name('admin.companyGroups.create')->middleware('check.admin.permission:COMPANYGROUP_CREATE');
          Route::get('/companyGroups/{id}/edit', [AdminCompanyGroupController::class, 'edit'])->name('admin.companyGroups.edit')->middleware('check.admin.permission:COMPANYGROUP_EDIT');
          Route::put('/companyGroups/{id}', [AdminCompanyGroupController::class, 'update'])->name('admin.companyGroups.update')->middleware('check.admin.permission:COMPANYGROUP_EDIT');
          Route::post('/companyGroups', [AdminCompanyGroupController::class, 'store'])->name('admin.companyGroups.store')->middleware('check.admin.permission:COMPANYGROUP_CREATE');
          Route::get('/companyGroups', [AdminCompanyGroupController::class, 'index'])->name('admin.companyGroups.index')->middleware('check.admin.permission:COMPANYGROUP_INDEX');

          Route::get('/companies/create', [AdminCompanyController::class, 'create'])->name('admin.companies.create')->middleware('check.admin.permission:COMPANY_CREATE');
          Route::get('/companies/{id}/edit', [AdminCompanyController::class, 'edit'])->name('admin.companies.edit')->middleware('check.admin.permission:COMPANY_EDIT');
          Route::put('/companies/{id}', [AdminCompanyController::class, 'update'])->name('admin.companies.update')->middleware('check.admin.permission:COMPANY_EDIT');
          Route::post('/companies', [AdminCompanyController::class, 'store'])->name('admin.companies.store')->middleware('check.admin.permission:COMPANY_CREATE');
          Route::get('/companies', [AdminCompanyController::class, 'index'])->name('admin.companies.index')->middleware('check.admin.permission:COMPANY_INDEX');
        //---

        // settings routes
          Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit')->middleware('check.admin.permission:USER_EDIT');
          Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update')->middleware('check.admin.permission:USER_EDIT');
          Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store')->middleware('check.admin.permission:USER_CREATE');
          Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index')->middleware('check.admin.permission:USER_INDEX');

          Route::get('/permissions/create', [AdminPermissionController::class, 'create'])->name('admin.permissions.create')->middleware('check.admin.permission:PERMISSION_CREATE');
          Route::get('/permissions/{id}/edit', [AdminPermissionController::class, 'edit'])->name('admin.permissions.edit')->middleware('check.admin.permission:PERMISSION_EDIT');
          Route::put('/permissions/{id}', [AdminPermissionController::class, 'update'])->name('admin.permissions.update')->middleware('check.admin.permission:PERMISSION_EDIT');
          Route::post('/permissions', [AdminPermissionController::class, 'store'])->name('admin.permissions.store')->middleware('check.admin.permission:PERMISSION_CREATE');
          Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('admin.permissions.index')->middleware('check.admin.permission:PERMISSION_INDEX');

          Route::put('/systems', [AdminSystemController::class, 'update'])->name('admin.systems.update')->middleware('check.admin.permission:SYSTEM_EDIT');
          Route::get('/systems', [AdminSystemController::class, 'index'])->name('admin.systems.index')->middleware('check.admin.permission:SYSTEM_INDEX');
        //---
      });
    //---

    // revenda routes
      Route::prefix('revenda')->group(function() {
        // routes without permission
          Route::post('/logout', [AuthController::class, 'logout'])->name('revenda.auth.logout');
          Route::get('/home', [RevendaHomeController::class, 'index'])->name('revenda.home.index');
        //---

        // user profile
          Route::get('/userProfile', [RevendaUserProfileController::class, 'index'])->name('revenda.userProfiles.index');
          Route::put('/userProfile', [RevendaUserProfileController::class, 'update'])->name('revenda.userProfiles.update');
        //---

        // records route
          Route::get('/companies/create', [RevendaCompanyController::class, 'create'])->name('revenda.companies.create')->middleware('check.revenda.permission:COMPANY_CREATE');
          Route::get('/companies/{id}/edit', [RevendaCompanyController::class, 'edit'])->name('revenda.companies.edit')->middleware('check.revenda.permission:COMPANY_EDIT');
          Route::put('/companies/{id}', [RevendaCompanyController::class, 'update'])->name('revenda.companies.update')->middleware('check.revenda.permission:COMPANY_EDIT');
          Route::post('/companies', [RevendaCompanyController::class, 'store'])->name('revenda.companies.store')->middleware('check.revenda.permission:COMPANY_CREATE');
          Route::get('/companies', [RevendaCompanyController::class, 'index'])->name('revenda.companies.index')->middleware('check.revenda.permission:COMPANY_INDEX');
        //---

        // settings routes
          Route::get('/users/create', [RevendaUserController::class, 'create'])->name('revenda.users.create')->middleware('check.revenda.permission:USER_CREATE');
          Route::get('/users/{id}/edit', [RevendaUserController::class, 'edit'])->name('revenda.users.edit')->middleware('check.revenda.permission:USER_EDIT');
          Route::put('/users/{id}', [RevendaUserController::class, 'update'])->name('revenda.users.update')->middleware('check.revenda.permission:USER_EDIT');
          Route::post('/users', [RevendaUserController::class, 'store'])->name('revenda.users.store')->middleware('check.revenda.permission:USER_CREATE');
          Route::get('/users', [RevendaUserController::class, 'index'])->name('revenda.users.index')->middleware('check.revenda.permission:USER_INDEX');

          Route::get('/permissions/create', [RevendaPermissionController::class, 'create'])->name('revenda.permissions.create')->middleware('check.revenda.permission:PERMISSION_CREATE');
          Route::get('/permissions/{id}/edit', [RevendaPermissionController::class, 'edit'])->name('revenda.permissions.edit')->middleware('check.revenda.permission:PERMISSION_EDIT');
          Route::put('/permissions/{id}', [RevendaPermissionController::class, 'update'])->name('revenda.permissions.update')->middleware('check.revenda.permission:PERMISSION_EDIT');
          Route::post('/permissions', [RevendaPermissionController::class, 'store'])->name('revenda.permissions.store')->middleware('check.revenda.permission:PERMISSION_CREATE');
          Route::get('/permissions', [RevendaPermissionController::class, 'index'])->name('revenda.permissions.index')->middleware('check.revenda.permission:PERMISSION_INDEX');

          Route::put('/systems', [RevendaSystemController::class, 'update'])->name('revenda.systems.update')->middleware('check.revenda.permission:SYSTEM_EDIT');
          Route::get('/systems', [RevendaSystemController::class, 'index'])->name('revenda.systems.index')->middleware('check.revenda.permission:SYSTEM_INDEX');
        //---
      });
    //---

    // ajax routes
      Route::prefix('ajax')->group(function() {
        Route::post('/zipCodeSearch', [ZipCodeController::class, 'search']);

        Route::get('/countySearch', [CountyController::class, 'search']);
        Route::get('/getCountyById', [CountyController::class, 'getCountyById']);
      });
    //---
  });
//---
