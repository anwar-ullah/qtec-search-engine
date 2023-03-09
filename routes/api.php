<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\PublicController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\LeadController;

//Public routes
Route::get('/system-informations', [PublicController::class, 'systemInformations']);

//Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Protected routes
Route::get('/user', [AuthController::class, 'user']);
Route::post('post-lead', [LeadController::class, 'postLead']);
Route::post('lead-bank', [LeadController::class, 'leadBank']);
Route::post('lead-status', [LeadController::class, 'leadStatus']);

