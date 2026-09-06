<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Ecommerce\Order;
use App\Models\Ecommerce\OrderItem;
use App\Models\Ecommerce\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:ecommerce_products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($validated, $request) {
            $total = 0;
            $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($validated['items'] as $item) {
                $product = $products[$item['product_id']];

                if ($product->stock < $item['quantity']) {
                    abort(422, "Insufficient stock for product: {$product->name}");
                }

                $total += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total' => $total,
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products[$item['product_id']];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        return response()->json($order->load('items.product'), 201);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json($order->load('items.product'));
    }
}
