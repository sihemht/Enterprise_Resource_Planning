<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStats(): JsonResponse{
        return response()->json([
            'total_revenue' => Order::sum('total_amount'),
            'orders_count' => Order::count(),
            'customers_count' => Customer::count(),
            'products_count' => Product::count(),
            //Top 5 ventes
            'top_products' => Order::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get()
        ]);
    }
}
