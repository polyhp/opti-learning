@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-primary-dark">Suivi des Paiements</h1>
            <p class="text-gray-500 mt-1">Consultez l'historique des transactions et exportez les rapports.</p>
        </div>
        
        <a href="{{ route('admin.payments.export') }}" class="flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Exporter en CSV
        </a>
    </div>

    <!-- KPIs Paiements -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium">Revenus Totaux</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center">
            <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium">Revenus ce mois ({{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('F') }})</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($monthlyRevenue, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par statut</label>
                <select name="status" id="status" class="rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm" onchange="this.form.submit()">
                    <option value="">Toutes les transactions</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Complétées</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>Échouées</option>
                </select>
            </div>
            
            @if($status)
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-primary-orange bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Table des paiements -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                        <th class="p-4 font-medium">ID Trans.</th>
                        <th class="p-4 font-medium">Client</th>
                        <th class="p-4 font-medium">Formation (Produit)</th>
                        <th class="p-4 font-medium">Montant</th>
                        <th class="p-4 font-medium">Date</th>
                        <th class="p-4 font-medium">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-500 font-mono text-xs">
                                #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="p-4">
                                @if($payment->user)
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                            <img src="{{ $payment->user->avatar_url }}" alt="" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $payment->user->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $payment->user->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Client introuvable</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <p class="text-gray-800 max-w-[200px] truncate" title="{{ $payment->course ? $payment->course->title : 'Inconnue' }}">
                                    {{ $payment->course ? $payment->course->title : 'Inconnue' }}
                                </p>
                            </td>
                            <td class="p-4">
                                <span class="font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} F</span>
                            </td>
                            <td class="p-4 text-gray-500">
                                {{ $payment->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4">
                                @if($payment->status === 'completed' || $payment->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        Succès
                                    </span>
                                @elseif($payment->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        En attente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                        Échoué/Annulé
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Aucune transaction trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
