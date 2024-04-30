<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Inertia('Home');
});

Route::get('/questions',[QuestionController::class,'index']);
Route::put('/questions',[QuestionController::class,'update']);
Route::post('/questions',[QuestionController::class,'store']);
Route::put('/answers',[AnswerController::class,'update']);
