<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    //store order and order item
    public function index(Request $request)
    {
        $orders = Order::with(['orderItems.product', 'kasir']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay(); // jam 00:00:00
            $end = Carbon::parse($request->end_date)->endOfDay();       // jam 23:59:59

            $orders->whereBetween('transaction_time', [$start, $end]);
        }

        return response()->json($orders->get());
    }
    public function store(Request $request)
    {
        $request->validate([
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
        ]);

        $order = \App\Models\Order::create([
            'transaction_time' => $request->transaction_time,
            'kasir_id' => $request->kasir_id,
            'total_price' => $request->total_price,
            'total_item' => $request->total_item,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($request->order_items as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order Created',
        ], 201);
    }
}
