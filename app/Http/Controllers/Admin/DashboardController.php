<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:admin');
    }

    public function stats()
    {
        return response()->json([
            'products_count' => Product::count(),
            'orders_count' => Order::count(),
            'users_count' => User::count(),
            'recent_orders' => Order::with('user')
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}