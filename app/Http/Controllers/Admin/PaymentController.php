<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = \App\Models\Order::with(['user', 'course']);

        if ($status && in_array($status, ['pending', 'completed', 'failed', 'refunded'])) {
            $query->where('status', $status);
        }

        $payments = $query->latest()->paginate(15)->withQueryString();
        
        $totalRevenue = \App\Models\Order::where('status', 'completed')->sum('amount');
        $monthlyRevenue = \App\Models\Order::where('status', 'completed')
                            ->whereMonth('created_at', now()->month)
                            ->sum('amount');

        return view('admin.payments.index', compact('payments', 'status', 'totalRevenue', 'monthlyRevenue'));
    }

    public function export()
    {
        $orders = \App\Models\Order::with(['user', 'course'])->latest()->get();

        $filename = "paiements_opti_learning_" . date('Y-m-d') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 Excel support
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['ID Commande', 'Client', 'Email', 'Formation', 'Montant', 'Statut', 'Date Parfaite']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user ? $order->user->full_name : 'N/A',
                    $order->user ? $order->user->email : 'N/A',
                    $order->course ? $order->course->title : 'N/A',
                    $order->amount . ' FCFA',
                    $order->status,
                    $order->created_at->format('d/m/Y H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
