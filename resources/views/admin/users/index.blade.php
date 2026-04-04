@extends('layouts.admin')

@section('content')
<div x-data="{ 
    showCreateModal: false, 
    showDeleteModal: false, 
    userToDelete: null, 
    showPermsModal: false, 
    userToManage: null, 
    manageRoute: '',
    roleFilter: '{{ $role }}',
    loading: false,
    applyFilter() {
        this.loading = true;
        let url = '{{ route('admin.users.index') }}';
        if (this.roleFilter && this.roleFilter !== '') {
            url += '?role=' + encodeURIComponent(this.roleFilter);
        }
        window.location.href = url;
    },
    resetFilters() {
        this.roleFilter = '';
        window.location.href = '{{ route('admin.users.index') }}';
    }
}">
    
    <!-- Header Section avec effet glassmorphism -->
    <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] p-6 shadow-xl">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(249,115,22,0.08)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#F97316]/20 flex items-center justify-center border border-[#F97316]/30">
                        <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Gestion des Utilisateurs</h1>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Gérez les apprenants, formateurs et administrateurs de la plateforme</p>
            </div>
            
            <button @click="showCreateModal = true" class="group flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#F97316] to-[#ea580c] text-white rounded-xl font-semibold shadow-lg hover:shadow-[#F97316]/30 transition-all duration-300 hover:scale-105">
                <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvel utilisateur
            </button>
        </div>
    </div>

    <!-- Filtres élégants -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-[#F97316]/20 p-5 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Filtrer par rôle :</span>
                </div>
                
                <select x-model="roleFilter" @change="applyFilter()" class="rounded-xl border-2 border-gray-200 focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 shadow-sm px-4 py-2 text-sm bg-white">
                    <option value="">📋 Tous les rôles</option>
                    <option value="apprenant">🎓 Apprenant</option>
                    <option value="formateur">👨‍🏫 Formateur</option>
                    <option value="admin">⚙️ Administrateur</option>
                    @if(auth()->user()->is_super_admin)
                        <option value="super_admin">🌟 Super Administrateur</option>
                    @endif
                </select>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-users mr-1"></i> {{ $users->total() }} utilisateur(s)
                </span>
                @if($role)
                    <button @click="resetFilters()" class="flex items-center gap-1 px-4 py-2 text-sm text-gray-600 hover:text-[#F97316] bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Réinitialiser
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Table des utilisateurs -->
    <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] text-white">
                        <th class="px-6 py-4 font-semibold text-sm">Utilisateur</th>
                        <th class="px-6 py-4 font-semibold text-sm">Rôle</th>
                        <th class="px-6 py-4 font-semibold text-sm">Statut</th>
                        <th class="px-6 py-4 font-semibold text-sm">Inscrit le</th>
                        <th class="px-6 py-4 font-semibold text-sm text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#FFF6EC] transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] flex items-center justify-center text-white font-bold text-lg shadow-md">
                                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                        </div>
                                        @if($user->is_active)
                                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white"></div>
                                        @else
                                            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-white"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $user->email }}</p>
                                        @if($user->phone)
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                             </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()" class="text-sm rounded-xl border-2 border-gray-200 focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 py-1.5 pl-3 pr-8 bg-white {{ $user->id === auth()->id() ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                        <option value="apprenant" {{ $user->role == 'apprenant' ? 'selected' : '' }}>🎓 Apprenant</option>
                                        <option value="formateur" {{ $user->role == 'formateur' ? 'selected' : '' }}>👨‍🏫 Formateur</option>
                                        <option value="admin" {{ $user->role == 'admin' && !$user->is_super_admin ? 'selected' : '' }}>⚙️ Admin</option>
                                        @if(auth()->user()->is_super_admin)
                                            <option value="super_admin" {{ $user->is_super_admin ? 'selected' : '' }}>🌟 Super Admin</option>
                                        @endif
                                    </select>
                                </form>
                             </td>
                            <td class="px-6 py-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Actif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Bloqué
                                    </span>
                                @endif
                             </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{ $user->created_at->format('d/m/Y') }}
                             </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($user->id !== auth()->id())
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200" title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        @if(auth()->check() && auth()->user()->is_super_admin && ($user->role == 'admin'))
                                            <button @click="showPermsModal = true; userToManage = '{{ $user->email }}'; manageRoute = '{{ route('admin.users.permissions', $user) }}'; setTimeout(() => { document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = false); @foreach($user->permissions as $perm) document.getElementById('perm_{{ str_replace('-', '_', $perm->name) }}').checked = true; @endforeach }, 50);" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-all duration-200" title="Gérer Accès">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 rounded-lg transition-all duration-200 {{ $user->is_active ? 'text-amber-600 hover:bg-amber-50' : 'text-emerald-600 hover:bg-emerald-50' }}" title="{{ $user->is_active ? 'Bloquer' : 'Activer' }}">
                                                @if($user->is_active)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <button @click="showDeleteModal = true; userToDelete = {{ $user->id }}" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200" title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic px-2 py-1 bg-gray-100 rounded-lg">Vous</span>
                                    @endif
                                </div>
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucun utilisateur trouvé</p>
                                    <button @click="showCreateModal = true" class="text-[#F97316] hover:text-[#ea580c] font-semibold text-sm">+ Ajouter un utilisateur</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de suppression -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showDeleteModal = false"></div>
            
            <div x-show="showDeleteModal" x-transition.scale class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-500 to-red-600"></div>
                
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Confirmer la suppression</h3>
                    <p class="text-gray-500 text-sm mb-6">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
                    
                    <div class="flex gap-3">
                        <button @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all">Annuler</button>
                        <form x-bind:action="`/admin/users/${userToDelete}`" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-medium hover:shadow-lg transition-all">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'ajout -->
    <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div x-show="showCreateModal" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showCreateModal = false"></div>
            
            <div x-show="showCreateModal" x-transition.scale class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#F97316] to-[#ea580c]"></div>
                
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#F97316]/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Ajouter un utilisateur</h3>
                    </div>
                    
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all" value="{{ old('first_name') }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all" value="{{ old('last_name') }}">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all" value="{{ old('email') }}" placeholder="exemple@opti-learning.com">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span class="text-gray-400 text-xs">(Optionnel)</span></label>
                                <input type="tel" name="phone" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all" value="{{ old('phone') }}" placeholder="+229 XX XX XX XX">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                                <select name="role" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 transition-all bg-white">
                                    <option value="apprenant">🎓 Apprenant</option>
                                    <option value="formateur">👨‍🏫 Formateur</option>
                                    <option value="admin">⚙️ Administrateur</option>
                                    @if(auth()->user()->is_super_admin)
                                        <option value="super_admin">🌟 Super Administrateur</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 mt-6 pt-4 border-t border-gray-100">
                            <button type="button" @click="showCreateModal = false" class="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all">Annuler</button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-[#F97316] to-[#ea580c] text-white rounded-xl font-medium hover:shadow-lg transition-all">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Gérer Permissions -->
    <div x-show="showPermsModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showPermsModal" @click="showPermsModal = false" class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm"></div>

            <div x-show="showPermsModal" class="relative inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 scale-enter-active">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Gérer les Accès Administrateur</h3>
                        <p class="text-xs text-gray-500" x-text="'Utilisateur : ' + userToManage"></p>
                    </div>
                </div>

                <div class="p-6">
                    <form :action="manageRoute" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="space-y-4">
                            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316] transition-all group">
                                <input type="checkbox" name="permissions[]" value="manage-users" id="perm_manage_users" class="perm-cb mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316]">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Utilisateurs</span>
                                    <span class="block text-xs text-gray-500 mt-1">Gérer les comptes formateurs et apprenants</span>
                                </div>
                            </label>

                            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316] transition-all group">
                                <input type="checkbox" name="permissions[]" value="manage-courses" id="perm_manage_courses" class="perm-cb mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316]">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Formations</span>
                                    <span class="block text-xs text-gray-500 mt-1">Valider ou rejeter les formations</span>
                                </div>
                            </label>

                            <label class="flex items-start p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316] transition-all group">
                                <input type="checkbox" name="permissions[]" value="manage-payments" id="perm_manage_payments" class="perm-cb mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316]">
                                <div class="ml-3">
                                    <span class="block text-sm font-bold text-gray-800">Paiements</span>
                                    <span class="block text-xs text-gray-500 mt-1">Suivre les transactions financières</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" @click="showPermsModal = false" class="px-4 py-2 border border-gray-300 rounded-xl bg-white text-gray-700 hover:bg-gray-50 font-semibold transition-all">Annuler</button>
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-purple-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Animation pour les modals */
    .scale-enter-active, .scale-leave-active { transition: all 0.3s ease; }
    .scale-enter-from, .scale-leave-to { opacity: 0; transform: scale(0.95); }
    .scale-enter-to, .scale-leave-from { opacity: 1; transform: scale(1); }
</style>
@endsection