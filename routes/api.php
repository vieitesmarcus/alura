<?php

use App\Http\Controllers\api\CategoriaController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\VideoController;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//FREE ROUTES
Route::get('/videos/free', function(){
    return response()->json(Video::limit(3)->get(), 200,['Content-Type'=>'application/json']);
});

Route::middleware('auth:sanctum')->group(function () {
//rotas VIDEO
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{video}', [VideoController::class, 'show']);
    Route::get('/videos/search/{name}', [VideoController::class, 'show']);
    Route::delete('/videos/{video}', [VideoController::class, 'destroy']);

    Route::post('/videos', [VideoController::class, 'store']);
    Route::put('/videos/{video}', [VideoController::class, 'update']);


//ROTAS CATEGORIA
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);
    Route::post('/categorias', [CategoriaController::class, "store"]);
    Route::put('/categorias/{categoria}', [CategoriaController::class, "update"]);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, "destroy"]);
    Route::get('/categorias/{categoria}/videos', [CategoriaController::class, "show"]);
});



//ROTAS LOGIN

Route::post('/login', [LoginController::class, 'doLogin']);

