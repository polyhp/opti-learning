<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Kkiapay - OptiLearning</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="bg-navy-50 font-sans text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 max-w-md w-full text-center relative overflow-hidden">

        <!-- Bande décorative -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-500 to-orange-600"></div>

        <!-- Icône -->
        <div
            class="w-20 h-20 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner">
            <i class="fas fa-lock"></i>
        </div>

        <h1 class="text-2xl font-head font-bold text-navy-900 mb-2">Finaliser votre achat</h1>

        <p class="text-slate-500 mb-8">Formation(s) :
            <span class="font-semibold text-slate-800">{{ $paymentData['titles'] }}</span>
        </p>

        <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
            <div class="flex justify-between items-center mb-3">
                <span class="text-slate-500 text-sm">Montant à payer</span>
                <span class="font-head font-bold text-xl text-navy-900">{{ number_format($paymentData['amount'], 0, ',', ' ') }}
                    FCFA</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-500 text-sm">N° Commande</span>
                <span class="font-mono text-xs text-navy-400">#{{ str_pad(explode(',', $paymentData['id'])[0], 6, '0', STR_PAD_LEFT) }}{{ strpos($paymentData['id'], ',') !== false ? '...' : '' }}</span>
            </div>
        </div>

        @if(empty(config('services.kkiapay.public_key')))
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm text-left shadow-sm">
                ❌ Clé Kkiapay introuvable. Vérifie ton fichier <code>.env</code>.
            </div>
        @else
            <button id="pay-btn"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 text-white font-bold py-4 px-6 rounded-xl shadow-lg mb-6">
                <i class="fas fa-mobile-screen mr-3"></i> Payer par Mobile Money
            </button>
            <div id="kkiapay-error" class="hidden text-red-500 text-sm mt-2 mb-4">
                Erreur d'initialisation Kkiapay
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
                class="text-sm text-slate-400 hover:text-navy-500 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Annuler et retourner
            </a>
        </div>
    </div>

    {{-- MODE SANDBOX LOCAL / PRODUCTION --}}
    @if(!empty(config('services.kkiapay.public_key')))
        <script src="https://cdn.kkiapay.me/k.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const payBtn = document.getElementById('pay-btn');
                if (!payBtn) return;

                payBtn.addEventListener('click', function () {
                    openKkiapayWidget({
                        amount: {{ round($paymentData['amount']) }},
                        position: "center",
                        callback: "{{ route('apprenant.payment.verify', ['order_id' => $paymentData['id']]) }}",
                        data: "{{ $paymentData['id'] }}",
                        theme: "#f97316", // Tailwind orange-500
                        key: "{{ config('services.kkiapay.public_key') }}",
                        sandbox: {{ config('services.kkiapay.sandbox') ? 'true' : 'false' }} 
                    });
                });

                // Écouteurs optionnels pour Kkiapay
                addSuccessListener(response => {
                    console.log('Paiement réussi:', response);
                });

                addFailedListener(error => {
                    console.log('Échec du paiement:', error);
                });
            });
        </script>
    @endif

</body>

</html>