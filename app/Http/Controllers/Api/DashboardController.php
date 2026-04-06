<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Services\TrendAnalysisService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected TrendAnalysisService $trendService;

    public function __construct(TrendAnalysisService $trendService)
    {
        $this->trendService = $trendService;
    }

    public function getStats(): JsonResponse{


        $topProducts = Order::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Analyse IA vérifie les risques de rupture pour le Top 5
        $stockAlerts = $topProducts->map(function ($order) {
            return $this->trendService->predictStockShortage($order->product);
        });

        return response()->json([
            'total_revenue' => round(Order::sum('total_amount'), 2),
            'orders_count' => Order::count(),
            'customers_count' => Customer::count(),
            'products_count' => Product::count(),
            'top_products' => $topProducts,
            'ai_stock_predictions' => $stockAlerts // <--- flux IA
        ]);
    }
}
