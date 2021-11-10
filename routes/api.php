<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicamentoController;
use App\Http\Controllers\Api\ReceitaController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
//Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->put('changepassword', [AuthController::class, 'changePassword']);

Route::get('medicamentos',                 [MedicamentoController::class, 'index']);
Route::post('medicamentos/pesquisa',                 [MedicamentoController::class, 'search']);
Route::middleware('auth:sanctum')->get('minhasreceitas',                 [ReceitaController::class, 'minhasReceitas']);
Route::middleware('auth:sanctum')->post('minhasreceitas',                [ReceitaController::class, 'store']);

Route::middleware('auth:sanctum')->get('receitasabertas',                 [ReceitaController::class, 'receitasAbertas']);
Route::middleware('auth:sanctum')->get('receitasfechadas',                 [ReceitaController::class, 'receitasFechadasPorMim']);
Route::middleware('auth:sanctum')->get('receitasrecusadas',                 [ReceitaController::class, 'receitasRecusadasPorMim']);
Route::middleware('auth:sanctum')->put('receitasabertas/close',                [ReceitaController::class, 'fecharReceita']);
Route::middleware('auth:sanctum')->put('receitasabertas/reject',                [ReceitaController::class, 'rejeitarReceita']);


