<?php

namespace App\Actions\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Action for retrieving and filtering products via API.
 *
 * Handles product search with filters for name, price range, category,
 * stock status, rating, and sorting options.
 */
class ProductApiGetAction
{
    /**
     * Retrieve a paginated list of products with optional filters and sorting.
     *
     * @param Request $request The HTTP request containing filter parameters:
     *                        - q: Search query for product name
     *                        - price_from: Minimum price filter
     *                        - price_to: Maximum price filter
     *                        - category_id: Filter by category ID
     *                        - in_stock: Filter by stock availability
     *                        - rating_from: Minimum rating filter
     *                        - sort: Sorting option (price_asc, price_desc, rating_desc, newest)
     *                        - per_page: Number of items per page (default: 50)
     *
     * @return LengthAwarePaginator Paginated collection of products
     */
    public function __invoke(Request $request): LengthAwarePaginator
    {
        return Product::query()
            ->when($request->has("q"), fn($query) => $query->whereFullText(
                    'name',
                    $request->q . '*',
                    ['mode' => 'boolean']
                ))
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
    }
}
