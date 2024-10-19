<?php

use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\BusinessHourController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleImageController;
use App\Http\Middleware\EnsureVehicleExist;
use App\Http\Middleware\EnsureVehicleImageExist;
use Illuminate\Support\Facades\Route;

Route::post('/users/create', [UserController::class, 'store'])->name('users.store'); // Rota para criar um novo usuário
Route::post('/users/login', [UserController::class, 'login'])->name('users.login'); // Rota para autenticar um usuário
Route::post('/stores', [StoreController::class, 'store'])->name('stores.store'); // Rota para criar uma nova loja

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [UserController::class, 'user'])->name('users.user'); // Rota para listar todos os usuários
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show'); // Rota para exibir um usuário específico
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Rota para atualizar um usuário
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Rota para deletar um usuário
    Route::post('/users/logout', [UserController::class, 'logout'])->name('users.logout'); // Rota para deslogar um usuário

    Route::get('/vehicles', [VehicleController::class, 'list'])->name('vehicles.list'); // Rota para listar todos os veículos
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show'); // Rota para exibir um veículo específico
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store'); // Rota para criar um novo veículo
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update'); // Rota para atualizar um veículo
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy')->middleware(EnsureVehicleExist::class); // Rota para deletar um veículo
    Route::get('/vehicles/{vehicle}/images', [VehicleImageController::class, 'list'])->middleware(EnsureVehicleExist::class)->name('vehicles.images.list'); // Rota para listar todas as imagens de um veículo

    Route::put('/vehicles/images/{image}', [VehicleImageController::class, 'update'])->name('vehicles.images.update')->middleware(EnsureVehicleImageExist::class); // Rota para atualizar uma imagem de um veículo
    Route::delete('/vehicles/images/{image}', [VehicleImageController::class, 'destroy'])->name('vehicles.images.destroy')->middleware(EnsureVehicleImageExist::class); // Rota para deletar uma imagem de um veículo
    Route::get('/vehicles/images/{vehicle}', [VehicleImageController::class, 'show'])->name('vehicles.images.show')->middleware(EnsureVehicleExist::class); // Rota para exibir a imagem capa do veículo
    Route::post('/vehicles/images', [VehicleImageController::class, 'store'])->name('vehicles.images.store'); // Rota para criar uma nova imagem de um veículo

    Route::get('/stores', [StoreController::class, 'list'])->name('stores.list'); // Rota para listar todas as lojas
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show'); // Rota para exibir uma loja específica
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update'); // Rota para atualizar uma loja

    Route::post('stores/hours', [BusinessHourController::class, 'store'])->name('stores.hours.store'); // Rota para criar um novo horário de atendimento
    Route::put('stores/hours/{businessHour}', [BusinessHourController::class, 'update'])->name('stores.hours.update'); // Rota para atualizar um horário de atendimento
});
