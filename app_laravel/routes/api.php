<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/chatbot/medicines', [
    ChatbotController::class,
    'searchMedicines',
]);

Route::post('/chatbot/analyze', [
    ChatbotController::class,
    'analyzeMessage',
]);

Route::post('/chatbot/retrieve', [
    ChatbotController::class,
    'retrieveKnowledge',
]);

Route::post(
    '/chatbot/chat',
    [ChatbotController::class, 'chat']
);
