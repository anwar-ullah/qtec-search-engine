<?php
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('register', function () {
    return redirect('dashboard');
});
