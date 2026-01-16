<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\ProductApiGetAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiProductRequest;

class ProductApiController extends Controller
{
    public function actionGet(ApiProductRequest $request, ProductApiGetAction $action)
    {
        return response()->json($action($request));
    }
}
