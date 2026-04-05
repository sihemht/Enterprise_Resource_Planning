<?php
namespace App\Services;


use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class TrendAnalysisService{
    public function predictStockShortage(Product $product)
    {
        // Calculer la moyenne des ventes par jour sur les 3 derniers mois
        $threeMonthsAgo = Carbon::now()->subMonths(3)->toDateString();
        $totalSold = Order::where('product_id', $product->id)
            ->where('order_date', '>=', $threeMonthsAgo)
            ->sum('quantity');
        $dailyAverage = $totalSold / 90; // Moyenne par jour

        //Estimer les besoins pour les 30 prochains jours
        $predictedNeed = $dailyAverage * 30;

        //Comparer avec le stock actuel
        $isShortageRisk = $product->stock_quantity < $predictedNeed;

        return [
            'product_name' => $product->name,
            'current_stock' => $product->stock_quantity,
            'predicted_demand_30d' => round($predictedNeed, 2),
            'status' => $isShortageRisk ? 'CRITICAL' : 'SAFE',
            'days_remaining' => $dailyAverage > 0 ? round($product->stock_quantity / $dailyAverage) : '∞'
        ];
    }
}
