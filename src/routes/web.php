<?php

use Oishin\Userservice\Controllers\UserserviceController;
use Illuminate\Support\Facades\Route;

Route::get('userservice', UserserviceController::class);

// Route::get('userservice', function(Oishin\Userservice\Userservice $userService) {
//     return $userService->justDoIt();
// });