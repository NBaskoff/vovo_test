<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::get("/user", function (Request $request) {
        return $request->user();
    });
});

Route::get("/products", [ProductApiController::class, "actionGet"]);



