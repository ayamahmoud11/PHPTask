<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Jobs\SendOrderNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return auth()->user()->orders()->with('items.product')->get();
    }

    public function store(OrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $order = auth()->user()->orders()->create([
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;
            
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $quantity = $item['quantity'];
                
                $orderItem = new OrderItem([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
                
                $order->items()->save($orderItem);
                
                $product->decrement('quantity', $quantity);
                $totalPrice += $product->price * $quantity;
            }
            
            $order->update(['total_price' => $totalPrice]);

            // Dispatch notification job
            SendOrderNotification::dispatch($order)->onQueue('notifications')->retry(3);

            return response()->json($order->load('items.product'), 201);
        });
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return $order->load('items.product');
    }
}