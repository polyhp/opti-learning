<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Affiche la vue de paiement Kkiapay pour une commande.
     */
    public function show($orderIds)
    {
        $ids = explode(',', $orderIds);
        $orders = Order::whereIn('id', $ids)->get();

        if ($orders->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Commande invalide.');
        }

        $courseTitles = [];
        $totalAmount = 0;
        foreach ($orders as $o) {
            if ($o->user_id !== auth()->id() || $o->status !== 'pending') {
                return redirect()->route('dashboard')->with('error', 'Commande invalide ou déjà payée.');
            }
            $totalAmount += $o->amount;
            if ($o->course) {
                $courseTitles[] = $o->course->title;
            }
        }

        $titles = count($courseTitles) > 0 ? implode(', ', $courseTitles) : 'Formations multiples';

        // Pour éviter l'utilisation de stdClass ou un modèle malformé dans la vue, 
        // on passe les données directement ou sous forme de tableau
        $paymentData = [
            'id' => $orderIds,
            'amount' => $totalAmount,
            'titles' => $titles
        ];

        return view('apprenant.payment', compact('paymentData'));
    }

    /**
     * Vérification synchrone après le retour de Kkiapay sur le site.
     */
    public function verify(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $orderId = $request->input('order_id');
        
        // 1. Priorité à la vérification locale si le webhook est déjà passé
        if ($orderId) {
            $ids = explode(',', $orderId);
            $order = Order::whereIn('id', $ids)->first();
            if ($order && $order->status === 'completed') {
                return redirect()->route('apprenant.dashboard')
                    ->with('success', 'Paiement déjà validé. Vous avez accès à vos formations !');
            }
        }

        if (!$transactionId) {
            return redirect()->route('dashboard')->with('error', 'Aucun identifiant de transaction trouvé.');
        }

        // 2. Vérification auprès de Kkiapay API
        $isSandbox = config('services.kkiapay.sandbox');
        $verifyUrl = $isSandbox 
            ? 'https://api-sandbox.kkiapay.me/api/v1/transactions/status'
            : 'https://api.kkiapay.me/api/v1/transactions/status';
        
        try {
            // L'API V1 de Kkiapay requiert expressément ces headers pour valider l'authenticité
            $response = Http::withHeaders([
                'x-api-key' => config('services.kkiapay.public_key'),
                'x-private-key' => config('services.kkiapay.private_key'),
                'x-secret-key' => config('services.kkiapay.secret'),
                'Accept' => 'application/json'
            ])->post($verifyUrl, [
                'transactionId' => $transactionId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Kkiapay renvoie le statut (ex: SUCCESS)
                if (isset($data['status']) && strtolower($data['status']) === 'success') {
                    // Retrouver les commandes par les IDs
                    $stateIds = $data['state'] ?? $orderId;
                    $ids = explode(',', $stateIds);
                    $orders = Order::whereIn('id', $ids)->get();
                    $processed = false;

                    /** @var \App\Models\Order $order */
                    foreach ($orders as $order) {
                        if ($order->status === 'pending') {
                            $order->update([
                                'status' => 'completed',
                                'transaction_id' => $transactionId,
                                'payment_method' => 'kkiapay'
                            ]);
                            
                            Payment::updateOrCreate(
                                ['reference' => $transactionId . '-' . $order->id],
                                [
                                    'order_id' => $order->id,
                                    'amount' => $order->amount,
                                    'gateway' => 'kkiapay',
                                    'status' => 'success',
                                    'gateway_response' => $data
                                ]
                            );
                            $processed = true;
                        }
                    }
                    
                    if ($processed) {
                        return redirect()->route('apprenant.dashboard')
                            ->with('success', 'Paiement effectué avec succès ! Vous avez maintenant accès à vos formations.');
                    } else {
                        return redirect()->route('apprenant.dashboard')
                            ->with('success', 'Paiement déjà validé !');
                    }
                }
            }
            
            // Si le statut n'est pas "success" ou requête échouée (ex: 401, 404)
            Log::warning('Échec de vérification Kkiapay', ['transaction_id' => $transactionId, 'status' => $response->status(), 'response' => $response->json()]);
            
        } catch (\Exception $e) {
            Log::error('Erreur API Kkiapay', ['message' => $e->getMessage()]);
        }

        return redirect()->route('dashboard')->with('error', 'Le paiement n\'a pas pu être vérifié de notre côté. Si vous avez été débité, veuillez contacter le support ou patienter.');
    }

    /**
     * Webhook asynchrone pour recevoir les notifications de Kkiapay.
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('x-kkiapay-signature'); // Ou x-kkiapay-secret selon la documentation
        
        $secret = config('services.kkiapay.secret');
        
        // Vérification basique de sécurité (HMAC hash ou simple égalité selon la version de Kkiapay)
        // Note: Selon la doc, x-kkiapay-secret est soit la clé secrète en clair, soit un hash.
        // Si c'est un hash : $expectedSignature = hash_hmac('sha256', $payload, $secret);
        // Si c'est la clé en brut : $signature == $secret
        
        if ($signature !== $secret && hash_hmac('sha256', $payload, $secret) !== $signature) {
            Log::warning('Kkiapay Webhook: Signature invalide', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);
        
        if (isset($data['event']) && $data['event'] === 'PAYMENT_SUCCESS') {
            $transactionId = $data['transactionId'];
            $orderId = $data['state']; // data passé dans le widget (peut être "15,16")
            
            $ids = explode(',', $orderId);
            $orders = Order::whereIn('id', $ids)->get();
            
            /** @var \App\Models\Order $order */
            foreach ($orders as $order) {
                if ($order->status === 'pending') {
                    $order->update([
                        'status' => 'completed',
                        'transaction_id' => $transactionId,
                        'payment_method' => 'kkiapay'
                    ]);
                    
                    Payment::updateOrCreate(
                        ['reference' => $transactionId . '-' . $order->id],
                        [
                            'order_id' => $order->id,
                            'amount' => $order->amount,
                            'gateway' => 'kkiapay',
                            'status' => 'success',
                            'gateway_response' => $data
                        ]
                    );
                    
                    Log::info('Kkiapay Webhook: Commande et Paiement validés', ['order_id' => $order->id]);
                }
            }
        }
        
        return response()->json(['status' => 'success']);
    }
}
