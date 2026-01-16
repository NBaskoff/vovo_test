<?php

namespace App\Actions\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiGetAction
{
    public function __invoke(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $products = Product::query()
            ->when($request->has("q"), fn($query) => $query->where("name", "LIKE", "%" . $request->input("q") . "%"))
            ->when($request->has("price_from"), fn($query) => $query->where("price", ">=", $request->input("price_from")))
            ->when($request->has("price_to"), fn($query) => $query->where("price", "<=", $request->input("price_to")))
            ->when($request->has("category_id"), fn($query) => $query->where("category_id", $request->input("category_id")))
            ->when($request->has("in_stock"), fn($query) => $query->where("in_stock", $request->input("in_stock")))
            ->when($request->has("rating_from"), fn($query) => $query->where("rating", ">=", $request->input("rating_from")))
            ->when($request->has("sort"), function ($query) use ($request) {
                return match ($request->input("sort")) {
                    "price_asc" => $query->orderBy("price", "asc"),
                    "price_desc" => $query->orderBy("price", "desc"),
                    "rating_desc" => $query->orderBy("rating", "desc"),
                    "newest" => $query->orderBy("created_at", "desc"),
                    default => $query
                };
            })
            ->paginate($request->input("per_page", 50));

        return $products;
    }
}
