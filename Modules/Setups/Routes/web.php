<?php

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

Route::prefix('setups')->group(function() {
    Route::resource('/', 'SetupsController');

    Route::resource('system-information', 'SystemInformationController');

    Route::resource('modules', 'ModulesController');

    Route::resource('menu', 'MenuController');

    Route::resource('submenu', 'SubmenuController');
    Route::get('submenu/{module_id}/get-menu', 'SubmenuController@getMenu');

    Route::resource('options', 'OptionsController');
    Route::get('options/{module_id}/get-menu', 'OptionsController@getMenu');
    Route::get('options/{menu_id}/get-submenu', 'OptionsController@getSubmenu');

    Route::resource('freelinks', 'FreelinksController');

    Route::resource('roles', 'RolesController');
    Route::resource('role-permissions', 'RolePermissionsController');

    Route::resource('admins', 'AdminController');

    Route::resource('my-profile', 'MyProfileController');
    Route::get('my-profile/{department_id}/get-subjects', 'MyProfileController@getSubjects');
    
    Route::resource('my-image', 'MyImageController');
    Route::resource('my-preferences', 'MyPreferencesController');
    Route::resource('change-password', 'ChangePasswordController');

    Route::resource('database-backups', 'DBBackupController');
});
