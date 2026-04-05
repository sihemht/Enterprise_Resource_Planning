<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportOrdersToCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-orders-to-c-s-v';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = \App\Models\Order::with(['product', 'customer'])->get();
        $handle = fopen(storage_path('app/orders_data.csv'), 'w');

        // Entêtes pour Pandas
        fputcsv($handle, ['date', 'product', 'category', 'quantity', 'amount', 'customer_country']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->order_date,
                $order->product->name,
                $order->product->category,
                $order->quantity,
                $order->total_amount,
                $order->customer->country
            ]);
        }
        fclose($handle);
        $this->info('Data exported for Python AI!');
    }
}
