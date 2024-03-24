<?php

use Oishin\Userservice\Controllers\UserserviceController;
use Oishin\Userservice\tests\unitTests;
use Illuminate\Support\Facades\Route;

//Route::resource('userservice', UserserviceController::class);

Route::get('userservice/user/{id}', [UserserviceController::class, 'getUserById']);
Route::get('userservice/page/{page?}', [UserserviceController::class, 'getUsers'])->defaults('page', 1);
Route::post('userservice/user', [UserserviceController::class, 'createUser']);

Route::get('/testGetUserById', [unitTests::class, 'testGetUserById']);
Route::get('/testGetUsersOnPage', [unitTests::class, 'testGetUsers']);
Route::post('/testCreateUser', [unitTests::class, 'testCreateUser']);