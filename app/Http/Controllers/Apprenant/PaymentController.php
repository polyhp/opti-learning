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
    public function show(Order $order)
    {
        // Vérifier que la commande appartient à l'utilisateur et qu'elle est en attente
        if ($order->user_id !== auth()->id() || $order->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Commande invalide ou déjà payée.');
        }

        return view('apprenant.payment', compact('order'));
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
            $order = Order::find($orderId);
            if ($order && $order->status === 'completed') {
                return redirect()->route('apprenant.courses.watch', $order->course_id)
                    ->with('success', 'Paiement déjà validé. Vous avez accès à la formation !');
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
                    // Retrouver la commande par l'ID fourni par le callback ou webhook
                    $order = $order ?? Order::find($data['state'] ?? $orderId);

                    if ($order && $order->status === 'pending') {
                        $order->update([
                            'status' => 'completed',
                            'transaction_id' => $transactionId,
                            'payment_method' => 'kkiapay'
                        ]);
                        
                        Payment::updateOrCreate(
                            ['reference' => $transactionId],
                            [
                                'order_id' => $order->id,
                                'amount' => $order->amount,
                                'gateway' => 'kkiapay',
                                'status' => 'success',
                                'gateway_response' => $data
                            ]
                        );
                        
                        return redirect()->route('apprenant.courses.watch', $order->course_id)
                            ->with('success', 'Paiement effectué avec succès ! Vous avez maintenant accès à la formation.');
                    } elseif ($order && $order->status === 'completed') {
                        return redirect()->route('apprenant.courses.watch', $order->course_id)
                            ->with('success', 'Paiement validé !');
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
            $orderId = $data['state']; // data passé dans le widget
            
            $order = Order::find($orderId);
            
            if ($order && $order->status === 'pending') {
                $order->update([
                    'status' => 'completed',
                    'transaction_id' => $transactionId,
                    'payment_method' => 'kkiapay'
                ]);
                
                Payment::updateOrCreate(
                    ['reference' => $transactionId],
                    [
                        'order_id' => $order->id,
                        'amount' => $order->amount,
                        'gateway' => 'kkiapay',
                        'status' => 'success',
                        'gateway_response' => $data
                    ]
                );
                
                Log::info('Kkiapay Webhook: Commande et Paiement validés', ['order_id' => $orderId]);
            }
        }
        
        return response()->json(['status' => 'success']);
    }
}
