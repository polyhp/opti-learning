<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceAccountInterface
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $role = auth()->user()->role;
            $prefix = $request->segment(1);

            // Liste des préfixes autorisés globalement pour les sessions actives
            $allowedPrefixes = [
                $role,
                'logout',
                'dashboard', // Si une route neutre dashboard existe
                'verify',    // Public : utilitaire de scan de certificat
                'formations',// Détails des formations publics
                'cart',      // Accès au panier
                ''           // Accueil racine
            ];

            // Ignorer les requêtes techniques ou d'API
            $isTechnical = $request->is('api/*') || 
                           $request->is('sanctum/*') || 
                           $request->is('storage/*') || 
                           $request->is('livewire/*') ||
                           $request->is('_debugbar/*');

            // Si le préfixe n'est pas autorisé
            $checkedPrefix = $prefix ?? '';
            
            // Exceptions spéciales pour permettre à tout le monde d'accéder au paiement et visionnage
            $isCheckoutOrPayment = $request->is('apprenant/checkout*') || 
                                   $request->is('apprenant/payment*') || 
                                   $request->is('apprenant/courses/*/watch');

            if (!$isTechnical && !$isCheckoutOrPayment && !in_array($checkedPrefix, $allowedPrefixes)) {
                return redirect()->route($role . '.dashboard');
            }
        }

        return $next($request);
    }
}
