@extends('layouts.admin')

@section('content')
<div x-data="{ showCreateModal: false, showDeleteModal: false, userToDelete: null }">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-primary-dark">Gestion des Utilisateurs</h1>
            <p class="text-gray-500 mt-1">Gérez les apprenants, formateurs et administrateurs.</p>
        </div>
        
        <button @click="showCreateModal = true" class="flex items-center px-4 py-2 bg-[#0A2647] text-white rounded-lg hover:bg-[#1E3A5F] transition-colors font-medium shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajouter un utilisateur
        </button>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par rôle</label>
                <select name="role" id="role" class="rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm" onchange="this.form.submit()">
                    <option value="">Tous les rôles</option>
                    <option value="apprenant" {{ $role == 'apprenant' ? 'selected' : '' }}>Apprenant</option>
                    <option value="formateur" {{ $role == 'formateur' ? 'selected' : '' }}>Formateur</option>
                    <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div>
            
            @if($role)
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-primary-orange bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-[0_10px_40px_-20px_rgba(0,0,0,0.08)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest border-b border-gray-100">
                        <th class="px-8 py-6 font-semibold">Utilisateur</th>
                        <th class="px-8 py-6 font-semibold">Rôle</th>
                        <th class="px-8 py-6 font-semibold">Statut</th>
                        <th class="px-8 py-6 font-semibold">Inscrit le</th>
                        <th class="px-8 py-6 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden border border-gray-200 shadow-[0_4px_10px_rgba(0,0,0,0.05)] shrink-0">
                                        <img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 leading-tight">{{ $user->full_name }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="text-sm rounded-lg border-gray-300 focus:border-primary-orange focus:ring-0 py-1 pl-2 pr-8 {{ $user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="apprenant" {{ $user->role == 'apprenant' ? 'selected' : '' }}>Apprenant</option>
                                        <option value="formateur" {{ $user->role == 'formateur' ? 'selected' : '' }}>Formateur</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Bloqué
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- Toggle Status Button --}}
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 {{ $user->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-colors" title="{{ $user->is_active ? 'Bloquer' : 'Activer' }}">
                                                @if($user->is_active)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        {{-- Delete trigger --}}
                                        <button @click="showDeleteModal = true; userToDelete = {{ $user->id }}" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">C'est vous</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Modale de suppression (dynamique) -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showDeleteModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <!-- Modal panel -->
            <div x-show="showDeleteModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left text-gray-800">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Supprimer l'utilisateur</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible et supprimera toutes les données associées.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form x-bind:action="`/admin/users/${userToDelete}`" method="POST" class="w-full sm:ml-3 sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:text-sm">Supprimer</button>
                    </form>
                    <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale d'ajout d'utilisateur -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showCreateModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showCreateModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#0A2647] to-[#1E3A5F]"></div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-8 pb-6 border-b border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-full bg-[#0A2647]/10 flex items-center justify-center mr-4">
                                <i class="fas fa-user-plus text-[#0A2647]"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-[#0A2647]">Ajouter un utilisateur</h3>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5 mb-5">
                            <!-- Prénom -->
                            <div>
                                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                                <input type="text" id="first_name" name="first_name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all" value="{{ old('first_name') }}">
                            </div>
                            <!-- Nom -->
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                                <input type="text" id="last_name" name="last_name" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all" value="{{ old('email') }}" placeholder="exemple@opti-learning.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5 mb-5">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                                <input type="password" id="password" name="password" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all">
                            </div>
                            <!-- Confirm password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmer mot de passe <span class="text-red-500">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="new_user_role" class="block text-sm font-semibold text-gray-700 mb-1">Rôle initial</label>
                            <select name="role" id="new_user_role" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm transition-all">
                                <option value="apprenant">Apprenant</option>
                                <option value="formateur">Formateur</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-2xl items-center">
                        <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 border border-gray-300 rounded-xl shadow-sm bg-white font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-all">Annuler</button>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#0A2647] to-[#1E3A5F] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">Ajouter l'utilisateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
