@extends('layouts.admin')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-primary-dark">Journal d'activités</h1>
        <p class="text-gray-500 mt-1">Consultez l'historique des actions effectuées par les administrateurs.</p>
    </div>
</div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par date</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}" class="rounded-lg border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm" onchange="this.form.submit()">
            </div>
            
            @if(request('date'))
                <a href="{{ route('admin.logs.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-[#FF6B35] bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Date</th>
                    <th class="px-6 py-4 font-medium">Administrateur</th>
                    <th class="px-6 py-4 font-medium">Action</th>
                    <th class="px-6 py-4 font-medium">Description</th>
                    <th class="px-6 py-4 font-medium">Adresse IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            <i class="far fa-clock mr-2 text-gray-400"></i>
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-primary-dark/10 text-primary-dark flex items-center justify-center font-bold mr-3">
                                    {{ substr($log->user->first_name ?? 'A', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $log->user->first_name ?? 'Inconnu' }} {{ $log->user->last_name ?? '' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 whitespace-normal break-words max-w-md">
                            {{ $log->description }}
                        </td>
                        <td class="px-6 py-4 text-gray-400 font-mono text-xs">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-history text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-base font-medium text-gray-600">Aucune activité enregistrée.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 border-opacity-50">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
