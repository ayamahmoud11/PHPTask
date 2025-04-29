<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin')->except(['index', 'show']);
    }

    public function index()
    {
        $userId = auth()->id();
        return Cache::remember("products.user.{$userId}", now()->addMinutes(15), function () {
            return auth()->user()->products;
        });
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return $product;
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());
        return $product;
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return response()->noContent();
    }
}