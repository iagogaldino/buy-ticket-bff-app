<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;

// Route('/users', [UserController::class]);
Route::patch('/users', [UserController::class, 'update']);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

Route::get('/events', [EventoController::class, 'index']);
Route::get('/sale', [EventoController::class, 'index']);

Route::get('/getTypeTickets/{eventID}', [TicketController::class, 'getTypeTickets']);
Route::get('/getTypeticketDesc', [TicketController::class, 'getTypeticketDesc']);
Route::post('/ticket', [TicketController::class, 'store']);

Route::post('/generateSale', [SaleController::class, 'generateSale']);
Route::get('/ticketsUser', [SaleController::class, 'ticketsUser']);
Route::get('/removeSale', [SaleController::class, 'removeSale']);

Route::post('/payment', [PaymentController::class, 'pay']);
Route::post('/payment-pix', [PaymentController::class, 'pix']);

Route::post('/login',[LoginController::class, 'login']);
