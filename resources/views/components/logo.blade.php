{{-- Chemin : resources/views/components/logo.blade.php --}}
<a {{ $attributes->merge(['href' => url('/'), 'class' => 'flex items-center space-x-3 group relative w-max']) }}>
    <!-- Effet de glow optionnel pour la brillance -->
    <div
        class="absolute -inset-4 bg-gradient-to-r from-[#FF6B35] to-[#FF8E5E] opacity-0 group-hover:opacity-20 blur-xl transition-all duration-500 rounded-full">
    </div>
    <div class="h-16 flex items-center justify-center transform transition-all duration-300 group-hover:scale-105">
        <img src="{{ asset('images/logo optilearning.jpg') }}" alt="OptiLearning"
            class="h-full w-auto object-contain drop-shadow-md rounded">
    </div>
</a>