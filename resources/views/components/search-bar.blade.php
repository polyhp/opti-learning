{{-- resources/views/components/search-bar.blade.php --}}
@props(['action' => route('home')])

@php
    $formateurs = \App\Models\Formateur::with('user')->where('validation_status', 'approved')->get();
    $categories = \App\Models\Category::all();
    $courses = \App\Models\Course::where('status', 'approved')->get();
    $maxPrice = \App\Models\Course::where('status', 'approved')->max('price') ?? 500000;

    // Pour le filtrage croisé (formateur -> catégorie)
    $courseLinks = $courses->map(function ($c) {
        return [
            'id' => $c->id,
            'title' => $c->title,
            'category_id' => $c->category_id,
            'formateur_id' => $c->formateur_id,
        ];
    });
@endphp

<!-- Injection d'AlpineJS uniquement si non présent -->
@once
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endonce

<form action="{{ $action }}" method="GET" x-data="searchComponent()"
    class="w-full mx-auto bg-[#0B1A3E] rounded-full shadow-md border border-[#F97316]/40 ring-1 ring-[#F97316]/30 flex flex-row lg:flex-row items-center overflow-x-auto lg:overflow-visible custom-scrollbar relative z-50 lg:max-h-12">

    <!-- Formateurs -->
    <div class="flex-none lg:flex-1 min-w-0 w-[110px] lg:w-auto px-2 lg:px-3 py-1 hover:bg-[#122255] transition rounded-l-full relative cursor-pointer group border-r border-[#F97316]/20 flex-shrink-0"
        @click.away="openFormateur = false">
        <label
            class="block text-[9px] lg:text-[10px] sm:text-xs font-bold text-orange-400  uppercase tracking-wider mb-0.5 lg:mb-1">Formateurs</label>

        <input type="hidden" name="trainer" x-model="selectedFormateurId">

        <div @click="openFormateur = !openFormateur"
            class="flex justify-between items-center text-[10px] lg:text-xs text-white ">
            <span x-text="selectedFormateurName || 'Tous formateurs'"
                :class="{'text-gray-400 ': !selectedFormateurName, 'font-medium text-white ': selectedFormateurName}"
                class="truncate"></span>
            <i class="fas fa-chevron-down text-orange-500  text-[10px] lg:text-xs transition-transform"
                :class="{'rotate-180': openFormateur}"></i>
        </div>

        <div x-show="openFormateur" x-transition.opacity
            class="fixed top-[120px] sm:top-[125px] md:top-[135px] left-4 right-4 lg:inset-auto lg:absolute lg:top-full lg:left-0 w-auto lg:w-72 mt-0 lg:mt-2 bg-[#0B1A3E] rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] lg:shadow-xl border border-[#F97316]/30 z-[100] overflow-hidden pb-0"
            style="display: none;">
            <div class="p-2 border-b border-[#F97316]/20 bg-[#0B1A3E]/90 backdrop-blur-md">
                <div class="relative">
                    <i class="fas fa-search absolute text-gray-400 left-3 top-2 lg:top-2.5 text-[10px] lg:text-xs"></i>
                    <input type="text" x-model="searchFormateur" placeholder="Rechercher..."
                        class="w-full pl-8 lg:pl-9 pr-3 py-1 bg-[#122255] border-none rounded-lg focus:ring-1 focus:ring-[#F97316] text-[10px] lg:text-xs text-white  placeholder-gray-400 outline-none transition-all">
                </div>
            </div>
            <ul class="max-h-56 lg:max-h-60 overflow-y-auto py-1 custom-scrollbar">
                <li @click="selectFormateur('', '')"
                    class="px-3 lg:px-4 py-2 hover:bg-[#F97316]/10 cursor-pointer text-[10px] lg:text-xs font-medium transition"
                    :class="{'bg-[#F97316]/20 text-[#F97316]': !selectedFormateurId, 'text-gray-200 ': selectedFormateurId}">
                    Tous les formateurs</li>
                <template x-for="f in filteredFormateurs" :key="f.id">
                    <li @click="selectFormateur(f.id, f.name)"
                        class="px-3 lg:px-4 py-2 hover:bg-[#F97316] hover:text-white cursor-pointer text-[10px] lg:text-xs transition truncate"
                        :class="{'bg-[#F97316] text-white font-medium': selectedFormateurId == f.id, 'text-gray-200 ': selectedFormateurId != f.id}">
                        <span x-text="f.name"></span>
                    </li>
                </template>
                <li x-show="filteredFormateurs.length === 0"
                    class="px-3 lg:px-4 py-3 text-[10px] lg:text-xs text-gray-400 text-center">Aucun résultat</li>
            </ul>
        </div>
    </div>

    <!-- Catégories -->
    <div class="flex-none lg:flex-1 min-w-0 w-[110px] lg:w-auto px-2 lg:px-3 py-1 hover:bg-[#122255] transition relative cursor-pointer group border-r border-[#F97316]/20 flex-shrink-0"
        @click.away="openCategory = false">
        <label
            class="block text-[9px] lg:text-[10px] sm:text-xs font-bold text-orange-400  uppercase tracking-wider mb-0.5 lg:mb-1">Catégories</label>

        <input type="hidden" name="category" x-model="selectedCategoryId">

        <div @click="openCategory = !openCategory"
            class="flex justify-between items-center text-[10px] lg:text-xs text-white ">
            <span x-text="selectedCategoryName || 'Toutes catégories'"
                :class="{'text-gray-400 ': !selectedCategoryName, 'font-medium text-white ': selectedCategoryName}"
                class="truncate"></span>
            <i class="fas fa-chevron-down text-orange-500  text-[10px] lg:text-xs transition-transform"
                :class="{'rotate-180': openCategory}"></i>
        </div>

        <div x-show="openCategory" x-transition.opacity
            class="fixed top-[120px] sm:top-[125px] md:top-[135px] left-4 right-4 lg:inset-auto lg:absolute lg:top-full lg:left-0 w-auto lg:w-72 mt-0 lg:mt-2 bg-[#0B1A3E] rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] lg:shadow-xl border border-[#F97316]/30 z-[100] overflow-hidden pb-0"
            style="display: none;">
            <div class="p-2 border-b border-[#F97316]/20 bg-[#0B1A3E]/90 backdrop-blur-md">
                <div class="relative">
                    <i class="fas fa-search absolute text-gray-400 left-3 top-2 lg:top-2.5 text-[10px] lg:text-xs"></i>
                    <input type="text" x-model="searchCategory" placeholder="Rechercher..."
                        class="w-full pl-8 lg:pl-9 pr-3 py-1 bg-[#122255] border-none rounded-lg focus:ring-1 focus:ring-[#F97316] text-[10px] lg:text-xs text-white  placeholder-gray-400 outline-none transition-all">
                </div>
            </div>
            <ul class="max-h-56 lg:max-h-60 overflow-y-auto py-1 custom-scrollbar">
                <li @click="selectCategory('', '')"
                    class="px-3 lg:px-4 py-2 hover:bg-[#F97316]/10 cursor-pointer text-[10px] lg:text-xs font-medium transition"
                    :class="{'bg-[#F97316]/20 text-[#F97316]': !selectedCategoryId, 'text-gray-200 ': selectedCategoryId}">
                    Toutes les catégories</li>
                <template x-for="c in filteredCategories" :key="c.id">
                    <li @click="selectCategory(c.id, c.name)"
                        class="px-3 lg:px-4 py-2 hover:bg-[#F97316] hover:text-white cursor-pointer text-[10px] lg:text-xs transition truncate"
                        :class="{'bg-[#F97316] text-white font-medium': selectedCategoryId == c.id, 'text-gray-200 ': selectedCategoryId != c.id}">
                        <span x-text="c.name"></span>
                    </li>
                </template>
                <li x-show="filteredCategories.length === 0"
                    class="px-3 lg:px-4 py-3 text-[10px] lg:text-xs text-gray-400 text-center">Aucun résultat</li>
            </ul>
        </div>
    </div>

    <!-- Titre -->
    <div class="flex-none lg:flex-1 min-w-0 w-[110px] lg:w-auto px-2 lg:px-3 py-1 hover:bg-[#122255] transition relative cursor-pointer group border-r border-[#F97316]/20 flex-shrink-0"
        @click.away="openTitle = false">
        <label
            class="block text-[9px] lg:text-[10px] sm:text-xs font-bold text-orange-400  uppercase tracking-wider mb-0.5 lg:mb-1">Formations</label>

        <input type="hidden" name="title" x-model="selectedTitle">

        <div @click="openTitle = !openTitle"
            class="flex justify-between items-center text-[10px] lg:text-xs text-white ">
            <span x-text="selectedTitle || 'Tous les titres'" class="truncate block max-w-full"
                :class="{'text-gray-400 ': !selectedTitle, 'font-medium text-white ': selectedTitle}"></span>
            <i class="fas fa-chevron-down text-orange-500  text-[10px] lg:text-xs transition-transform"
                :class="{'rotate-180': openTitle}"></i>
        </div>

        <div x-show="openTitle" x-transition.opacity
            class="fixed top-[120px] sm:top-[125px] md:top-[135px] left-4 right-4 lg:inset-auto lg:absolute lg:top-full lg:left-0 w-auto lg:w-72 mt-0 lg:mt-2 bg-[#0B1A3E] rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] lg:shadow-xl border border-[#F97316]/30 z-[100] overflow-hidden pb-0"
            style="display: none;">
            <div class="p-2 border-b border-[#F97316]/20 bg-[#0B1A3E]/90 backdrop-blur-md">
                <div class="relative">
                    <i class="fas fa-search absolute text-gray-400 left-3 top-2 lg:top-2.5 text-[10px] lg:text-xs"></i>
                    <input type="text" x-model="searchTitle" placeholder="Rechercher..."
                        class="w-full pl-8 lg:pl-9 pr-3 py-1 bg-[#122255] border-none rounded-lg focus:ring-1 focus:ring-[#F97316] text-[10px] lg:text-xs text-white  placeholder-gray-400 outline-none transition-all">
                </div>
            </div>
            <ul class="max-h-56 lg:max-h-60 overflow-y-auto py-1 custom-scrollbar">
                <li @click="selectTitle('')"
                    class="px-3 lg:px-4 py-2 hover:bg-[#F97316]/10 cursor-pointer text-[10px] lg:text-xs font-medium transition"
                    :class="{'bg-[#F97316]/20 text-[#F97316]': !selectedTitle, 'text-gray-200 ': selectedTitle}">Tous
                    les titres</li>
                <template x-for="t in filteredTitles" :key="t">
                    <li @click="selectTitle(t)"
                        class="px-3 lg:px-4 py-2 hover:bg-[#F97316] hover:text-white cursor-pointer text-[10px] lg:text-xs transition truncate"
                        :class="{'bg-[#F97316] text-white font-medium': selectedTitle === t, 'text-gray-200 ': selectedTitle !== t}">
                        <span x-text="t"></span>
                    </li>
                </template>
                <li x-show="filteredTitles.length === 0"
                    class="px-3 lg:px-4 py-3 text-[10px] lg:text-xs text-gray-400 text-center">Aucun résultat</li>
            </ul>
        </div>
    </div>

    <!-- Prix -->
    <div class="flex-none lg:flex-1 min-w-0 w-[110px] lg:w-auto px-2 lg:px-3 py-1 hover:bg-[#122255] transition relative cursor-pointer group border-r lg:border-r-0 border-transparent flex-shrink-0"
        @click.away="openPrice = false">
        <label
            class="block text-[9px] lg:text-[10px] sm:text-xs font-bold text-orange-400  uppercase tracking-wider mb-0.5 lg:mb-1">Prix
            Limite</label>

        <input type="hidden" name="price_max" x-model="selectedPrice">

        <div @click="openPrice = !openPrice"
            class="flex justify-between items-center text-[10px] lg:text-xs text-white ">
            <span x-text="selectedPrice ? selectedPrice + ' XOF' : 'Tous les prix'"
                :class="{'text-gray-400 ': !selectedPrice, 'font-medium text-white ': selectedPrice}"></span>
            <i class="fas fa-chevron-down text-orange-500  text-[10px] lg:text-xs transition-transform"
                :class="{'rotate-180': openPrice}"></i>
        </div>

        <div x-show="openPrice" x-transition.opacity
            class="fixed top-[120px] sm:top-[125px] md:top-[135px] left-4 right-4 lg:inset-auto lg:absolute lg:top-full lg:right-0 lg:left-auto w-auto lg:w-72 mt-0 lg:mt-2 bg-[#0B1A3E] rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.5)] lg:shadow-xl border border-[#F97316]/30 z-[100] p-4"
            style="display: none;">

            <div class="flex justify-between text-[10px] lg:text-xs text-gray-400 lg:text-gray-500 mb-2 font-medium">
                <span>0</span>
                <span x-text="currentPriceDisplay + ' XOF'"
                    class="text-[#F97316] font-bold bg-orange-500/10 lg:bg-transparent px-2 py-0.5 rounded"></span>
                <span>{{ $maxPrice }}</span>
            </div>

            <input type="range" x-model="currentPriceDisplay" min="0" max="{{ $maxPrice }}" step="1000"
                class="w-full h-1.5 lg:h-2 bg-navy-800 lg:bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#F97316]">

            <div class="mt-4 flex gap-2">
                <button type="button" @click="selectPrice('')"
                    class="flex-1 py-1 bg-navy-800 lg:bg-gray-100 hover:bg-navy-700 lg:hover:bg-gray-200 text-white  rounded lg:rounded-lg text-[11px] lg:text-xs font-medium transition">Réinitialiser</button>
                <button type="button" @click="selectPrice(currentPriceDisplay)"
                    class="flex-1 py-1 bg-orange-500 hover:bg-orange-600 text-white rounded lg:rounded-lg text-[11px] lg:text-xs font-medium transition shadow-lg lg:shadow-none shadow-orange-500/20">Appliquer</button>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div
        class="p-1 pr-1 bg-transparent rounded-r-full flex justify-center sticky right-0 bg-navy-900 border-l border-[#F97316]/20 border-l z-10 hidden sm:flex mt-auto lg:mt-0">
        <button type="submit"
            class="w-full lg:w-auto bg-gradient-to-r from-[#F97316] to-[#EA580C] lg:bg-[#F97316] hover:from-[#EA580C] hover:to-[#C2410C] lg:hover:bg-[#EA580C] text-white p-1.5 lg:px-4 lg:py-1.5 rounded-full flex items-center justify-center transition-all shadow-lg lg:shadow-md shadow-orange-500/30 lg:shadow-none transform hover:scale-105">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
        </button>
    </div>

    <!-- Submit Mobile Icon seulement (pas fixé pour le scroll horizontal fluide) -->
    <div class="p-1.5 bg-transparent flex justify-center sm:hidden flex-none flex-shrink-0 mr-1 items-center">
        <button type="submit"
            class="bg-gradient-to-r from-[#F97316] to-[#EA580C] text-white p-3 rounded-xl flex items-center justify-center shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                </path>
            </svg>
        </button>
    </div>

</form>

<style>
    /* Custom Scrollbar for dropdowns */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(30, 41, 59, 0.5);
        /* navy-800 fallback */
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(249, 115, 22, 0.8);
        /* orange-500 fallback */
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(234, 88, 12, 1);
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('searchComponent', () => ({
            // Données complètes JSON injectées depuis PHP
            allFormateurs: @json($formateurs->map(fn($f) => ['id' => $f->id, 'name' => $f->user->first_name . ' ' . $f->user->last_name])),
            allCategories: @json($categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name])),
            allTitles: @json($courses->pluck('title')->unique()->values()),
            courseLinks: @json($courseLinks),

            // États des dropdowns
            openFormateur: false,
            openCategory: false,
            openTitle: false,
            openPrice: false,

            // Recherches saisies dans les dropdowns
            searchFormateur: '',
            searchCategory: '',
            searchTitle: '',

            // Sélections actuelles
            selectedFormateurId: '{{ request("trainer") }}',
            selectedFormateurName: '',
            selectedCategoryId: '{{ request("category") }}',
            selectedCategoryName: '',
            selectedTitle: '{{ request("title") }}',
            selectedPrice: '{{ request("price_max") }}',
            currentPriceDisplay: '{{ request("price_max") ?? $maxPrice }}',

            init() {
                // Initialisation des noms si IDs présents dans l'URL
                if (this.selectedFormateurId) {
                    let f = this.allFormateurs.find(x => x.id == this.selectedFormateurId);
                    if (f) this.selectedFormateurName = f.name;
                }
                if (this.selectedCategoryId) {
                    let c = this.allCategories.find(x => x.id == this.selectedCategoryId);
                    if (c) this.selectedCategoryName = c.name;
                }
            },

            get filteredFormateurs() {
                return this.allFormateurs.filter(f => f.name.toLowerCase().includes(this.searchFormateur.toLowerCase()));
            },

            // Dynamique : si formateur sélectionné, filtrer les catégories
            get filteredCategories() {
                let cats = this.allCategories;

                // Si le formateur est sélectionné, on ne garde que les catégories où il a des cours
                if (this.selectedFormateurId) {
                    let availableCategoryIds = this.courseLinks
                        .filter(cl => cl.formateur_id == this.selectedFormateurId)
                        .map(cl => cl.category_id);
                    availableCategoryIds = [...new Set(availableCategoryIds)];
                    cats = cats.filter(c => availableCategoryIds.includes(c.id));
                }

                // Puis on applique la recherche textuelle locale
                return cats.filter(c => c.name.toLowerCase().includes(this.searchCategory.toLowerCase()));
            },

            // Dynamique : Filtrer les titres
            get filteredTitles() {
                let links = this.courseLinks;

                if (this.selectedFormateurId) {
                    links = links.filter(cl => cl.formateur_id == this.selectedFormateurId);
                }
                if (this.selectedCategoryId) {
                    links = links.filter(cl => cl.category_id == this.selectedCategoryId);
                }

                let titles = [...new Set(links.map(cl => cl.title))];

                return titles.filter(t => t.toLowerCase().includes(this.searchTitle.toLowerCase()));
            },

            selectFormateur(id, name) {
                this.selectedFormateurId = id;
                this.selectedFormateurName = name;
                this.openFormateur = false;
            },

            selectCategory(id, name) {
                this.selectedCategoryId = id;
                this.selectedCategoryName = name;
                this.openCategory = false;
            },

            selectTitle(title) {
                this.selectedTitle = title;
                this.openTitle = false;
            },

            selectPrice(val) {
                this.selectedPrice = val;
                this.openPrice = false;
            }
        }))
    });
</script>