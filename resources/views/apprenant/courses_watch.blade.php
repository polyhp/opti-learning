<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecteur : {{ $course->title }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], head: ['Outfit', 'sans-serif'] },
                    colors: { navy: { 50: '#F4F7FB', 100: '#E6EDF5', 800: '#1d3566', 900: '#0B1A3E' }, orange: { 500: '#F97316', 600: '#ea580c' } }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
        
        .tab-btn.active {
            border-bottom: 3px solid #F97316;
            color: #111827;
            font-weight: 600;
        }
        
        .lesson-item.active {
            background-color: #F4F7FB;
            border-left: 4px solid #F97316;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans h-screen flex flex-col overflow-hidden">

    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 sm:px-6 flex-shrink-0 shadow-sm z-50">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center shadow-md"><i class="fas fa-graduation-cap text-white text-sm"></i></div>
                <span class="text-xl font-head font-bold text-navy-900 hidden sm:block">OPTI<span class="text-orange-500">LEARNING</span></span>
            </a>
            <div class="h-6 w-px bg-slate-300 mx-2 hidden sm:block"></div>
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-navy-900 transition-colors text-sm font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Mon espace
            </a>
            <div class="h-6 w-px bg-slate-300 mx-2"></div>
            <h1 class="text-navy-900 font-head font-bold truncate max-w-[200px] sm:max-w-md md:max-w-lg" title="{{ $course->title }}">{{ $course->title }}</h1>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Progression factice pour l'instant -->
            <div class="hidden md:flex items-center space-x-3">
                <span class="text-xs font-semibold text-slate-500" id="progress-text">0% complété</span>
                <div class="w-32 h-2 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 w-0 transition-all duration-500" id="progress-bar"></div>
                </div>
            </div>
            <span class="text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1.5 rounded-full shadow-sm"><i class="fas fa-unlock mr-1"></i>Accès Garanti</span>
        </div>
    </header>

    @if(session('success'))
    <div class="bg-emerald-500 text-white text-center py-2 text-sm font-medium w-full flex-shrink-0" id="flashInfo">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex-grow flex flex-col lg:flex-row overflow-hidden">
        
        <!-- Main Player & Tabs Area -->
        <main class="flex-grow flex flex-col relative bg-slate-50 overflow-y-auto w-full lg:w-3/4">
            
            <!-- Video Container (Dark cinematic section) -->
            <div class="w-full bg-black relative flex items-center justify-center flex-shrink-0" id="player-container" style="height: 60vh; max-height: 600px; min-height: 350px;">
                @if($course->lessons->count() > 0)
                    @php $firstVideo = $course->lessons->where('type', 'video')->first(); @endphp
                    @if($firstVideo)
                        <video id="main-player" controls class="w-full h-full outline-none shadow-2xl" poster="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}">
                            <source src="{{ asset($firstVideo->file_path) }}" type="video/mp4" id="video-source">
                            Votre navigateur ne supporte pas la lecture vidéo.
                        </video>
                    @else
                        <div class="text-center p-8">
                            <i class="fas fa-file-pdf text-6xl text-slate-500 mb-4"></i>
                            <h3 class="text-xl text-white font-medium">Contenu documentaire</h3>
                            <p class="text-sm text-slate-400 mt-2">Ce cours ne contient pas de vidéos. Lisez les documents dans le menu de droite.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center text-slate-500">
                        <i class="fas fa-box-open text-4xl mb-4"></i>
                        <p>Aucun contenu n'a été publié pour cette formation.</p>
                    </div>
                @endif
                
                <!-- Quiz Modal (Hidden by default, overlays video) -->
                <div id="quiz-overlay" class="absolute inset-0 bg-navy-900 border-t-4 border-orange-500 z-50 overflow-y-auto hidden custom-scrollbar">
                    <div class="max-w-3xl mx-auto py-12 px-6">
                        @if($course->quizzes->count() > 0)
                            @php $quiz = $course->quizzes->first(); @endphp
                            <div class="text-center mb-10">
                                <div class="w-20 h-20 bg-orange-500/20 text-orange-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-4 border border-orange-500/50 shadow-[0_0_15px_rgba(249,115,22,0.3)]"><i class="fas fa-award"></i></div>
                                <h2 class="text-3xl font-head font-bold text-white mb-2">Quiz : {{ $quiz->title ?? 'Évaluation Finale' }}</h2>
                                <p class="text-slate-300 font-medium bg-white/10 inline-block px-4 py-1 rounded-full text-sm mt-2">Score requis pour validation : <strong class="text-orange-400">{{ $quiz->passing_score }}%</strong></p>
                            </div>
                            
                            <form id="quiz-form" class="space-y-6" onsubmit="submitQuiz(event)">
                                @foreach($quiz->questions as $qIndex => $q)
                                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl shadow-lg">
                                        <h3 class="text-white text-lg font-semibold mb-5"><span class="text-orange-500 mr-2 bg-orange-500/10 px-2 py-1 rounded">Q{{ $qIndex + 1 }}</span> {{ $q->question_text }}</h3>
                                        <div class="space-y-3">
                                            @foreach($q->options as $opt)
                                                <label class="flex items-center space-x-3 p-4 rounded-xl border border-white/10 hover:border-orange-500/50 hover:bg-white/10 cursor-pointer transition-all option-label">
                                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->is_correct ? '1' : '0' }}" class="w-5 h-5 accent-orange-500" required>
                                                    <span class="text-slate-300 font-medium select-none">{{ $opt->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                
                                <button type="submit" id="submit-quiz-btn" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 rounded-xl shadow-xl shadow-orange-500/30 transition-all transform hover:-translate-y-1 text-lg flex justify-center items-center mt-8">
                                    <i class="fas fa-paper-plane mr-2"></i> Valider mes réponses
                                </button>
                                
                                <div id="quiz-result" class="hidden rounded-2xl border p-8 text-center mt-8 bg-white/5 backdrop-blur-sm"></div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabs Section (White background) -->
            <div class="w-full bg-white border-b border-slate-200">
                <div class="max-w-5xl mx-auto px-6">
                    <div class="flex space-x-8">
                        <button class="tab-btn active py-4 text-slate-500 hover:text-navy-900 font-medium transition-colors outline-none" onclick="switchTab('overview')">Aperçu</button>
                        <button class="tab-btn py-4 text-slate-500 hover:text-navy-900 font-medium transition-colors outline-none" onclick="switchTab('resources')">Ressources</button>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="flex-grow bg-slate-50 p-6 pb-20">
                <div class="max-w-5xl mx-auto">
                    <!-- Overview Tab -->
                    <div id="tab-overview" class="tab-content" style="display: block;">
                        <h2 class="text-2xl font-head font-bold text-navy-900 mb-2" id="current-title">Chargement...</h2>
                        <div class="flex items-center text-sm text-slate-500 mb-8 border-b border-slate-200 pb-4">
                            <span class="bg-navy-50 text-navy-700 px-3 py-1 rounded-full text-xs font-semibold mr-4" id="current-type">Vidéo</span>
                            <span>Auteur : {{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}</span>
                        </div>
                        
                        <div class="prose prose-slate max-w-none">
                            <h3 class="text-lg font-bold text-slate-800 mb-3">À propos de ce cours</h3>
                            <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $course->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Resources Tab -->
                    <div id="tab-resources" class="tab-content hidden">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Ressources téléchargeables</h3>
                        <div class="bg-white rounded-xl border border-slate-200 p-6 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-folder-open text-4xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500">Toutes les ressources mentionnées dans la leçon vidéo apparaîtront ici.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>

        <!-- Sidebar (Playlist - Light Theme) -->
        <aside class="w-full lg:w-1/4 bg-white border-l border-slate-200 flex flex-col flex-shrink-0 h-96 lg:h-auto shadow-[-4px_0_15px_rgba(0,0,0,0.03)] z-10">
            <div class="p-5 border-b border-slate-200 bg-white sticky top-0 z-20">
                <h3 class="text-navy-900 font-head font-bold text-lg">Contenu du cours</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-slate-500 font-medium">{{ $course->lessons->count() }} leçons</span>
                </div>
            </div>
            
            <div class="overflow-y-auto custom-scrollbar flex-grow bg-slate-50" id="playlist">
                @foreach($course->lessons as $index => $lesson)
                    <div class="lesson-item border-b border-slate-200 hover:bg-slate-100 transition-colors flex items-stretch group cursor-pointer" 
                         data-type="{{ $lesson->type }}" 
                         data-url="{{ asset($lesson->file_path) }}" 
                         data-title="{{ $index + 1 }}. {{ $lesson->title }}"
                         onclick="playLesson(this)">
                        
                        <!-- Checkbox Logic -->
                        <div class="w-12 flex items-center justify-center flex-shrink-0 border-r border-slate-100" onclick="toggleCompletion(event, this)">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center text-white transition-colors check-icon">
                                <i class="fas fa-check text-[10px] opacity-0 transition-opacity"></i>
                            </div>
                        </div>

                        <!-- Lesson info -->
                        <div class="p-4 flex-grow flex items-start">
                            <div class="mt-0.5 text-slate-400 group-hover:text-orange-500 transition-colors w-6 flex-shrink-0 text-center">
                                @if($lesson->type == 'video')
                                    <i class="fas fa-play-circle"></i>
                                @else
                                    <i class="fas fa-file-alt"></i>
                                @endif
                            </div>
                            <div class="ml-2 pr-2">
                                <h4 class="text-sm font-medium text-slate-700 leading-snug lesson-title-text group-hover:text-navy-900">{{ $index + 1 }}. {{ $lesson->title }}</h4>
                                <div class="text-xs text-slate-500 mt-1 flex items-center">
                                    <i class="fas fa-clock mr-1 opacity-50"></i> {{ $lesson->type == 'video' ? 'Vidéo' : 'Lecture' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($course->quizzes->count() > 0)
                    <div class="lesson-item border-b border-slate-200 hover:bg-orange-50 transition-colors flex items-center bg-white cursor-pointer" onclick="showQuiz(this)">
                        <div class="w-12 h-full py-5 flex items-center justify-center flex-shrink-0 border-r border-slate-100"></div>
                        <div class="p-4 flex-grow flex items-center">
                            <div class="text-orange-500 w-6 flex-shrink-0 text-center"><i class="fas fa-award text-lg"></i></div>
                            <div class="ml-2 font-head font-bold text-orange-600">Passer l'Évaluation</div>
                        </div>
                    </div>
                @endif
            </div>
        </aside>
    </div>

    <script>
        // Flash message timeout
        setTimeout(() => { if(document.getElementById('flashInfo')) document.getElementById('flashInfo').style.display = 'none'; }, 4000);

        // State trackers
        let completedLessons = 0;
        const totalLessons = {{ $course->lessons->count() }};

        function updateProgress() {
            if(totalLessons === 0) return;
            const percentage = Math.round((completedLessons / totalLessons) * 100);
            document.getElementById('progress-text').textContent = percentage + '% complété';
            document.getElementById('progress-bar').style.width = percentage + '%';
        }

        // Fake completion toggler
        function toggleCompletion(event, el) {
            event.stopPropagation(); // don't trigger the row click
            const checkIcon = el.querySelector('.check-icon');
            const iconMarker = checkIcon.querySelector('i');
            
            if (checkIcon.classList.contains('bg-emerald-500')) {
                // uncheck
                checkIcon.classList.remove('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.add('border-slate-300');
                iconMarker.classList.remove('opacity-100');
                iconMarker.classList.add('opacity-0');
                completedLessons = Math.max(0, completedLessons - 1);
            } else {
                // check
                checkIcon.classList.add('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.remove('border-slate-300');
                iconMarker.classList.remove('opacity-0');
                iconMarker.classList.add('opacity-100');
                completedLessons = Math.min(totalLessons, completedLessons + 1);
            }
            updateProgress();
        }

        function playLesson(container) {
            // UI Updates
            document.querySelectorAll('.lesson-item').forEach(b => {
                b.classList.remove('active', 'border-l-4', 'border-orange-500');
                b.style.borderLeft = '';
            });
            container.classList.add('active');
            
            const title = container.getAttribute('data-title');
            const url = container.getAttribute('data-url');
            const type = container.getAttribute('data-type');
            
            document.getElementById('current-title').textContent = title;
            document.getElementById('current-type').textContent = type === 'video' ? 'Leçon Vidéo' : 'Support Documentaire';
            
            // Hide quiz if open
            document.getElementById('quiz-overlay').classList.add('hidden');
            
            // Video Logic
            const player = document.getElementById('main-player');
            if(player && type === 'video') {
                player.style.display = 'block';
                document.getElementById('video-source').setAttribute('src', url);
                player.load();
                player.play();
                switchTab('overview');
            } else if (type !== 'video') {
                if(player) {
                    player.pause();
                    // optional: player.style.display = 'none';
                }
                window.open(url, '_blank');
            }
        }
        
        // Auto-select first lesson on load
        window.addEventListener('DOMContentLoaded', () => {
            const firstLesson = document.querySelector('.lesson-item[data-url]');
            if (firstLesson) {
                playLesson(firstLesson);
                const player = document.getElementById('main-player');
                if(player) {
                    player.pause(); // prevent autoplay blast
                }
            }
        });

        function showQuiz(container) {
            const player = document.getElementById('main-player');
            if(player) {
                player.pause();
                player.style.display = 'none';
            }
            document.getElementById('quiz-overlay').classList.remove('hidden');
            document.getElementById('current-title').textContent = "Évaluation Finale";
            document.getElementById('current-type').textContent = "Quiz à choix multiples";
            
            document.querySelectorAll('.lesson-item').forEach(b => b.classList.remove('active'));
            if(container) container.classList.add('active');
        }

        function submitQuiz(e) {
            e.preventDefault();
            const form = document.getElementById('quiz-form');
            const submitBtn = document.getElementById('submit-quiz-btn');
            const resultBox = document.getElementById('quiz-result');
            
            let total = 0;
            let correct = 0;
            
            const formData = new FormData(form);
            for(let [name, value] of formData) {
                total++;
                if(value === '1') correct++;
            }
            
            let score = Math.round((correct / total) * 100);
            const passingScore = {{ isset($course->quizzes[0]) ? $course->quizzes[0]->passing_score : 50 }};
            const passed = score >= passingScore;
            
            // Highlight Answers
            form.querySelectorAll('input[type="radio"]').forEach(radio => {
                const label = radio.closest('.option-label');
                if(radio.checked) {
                    if(radio.value === '1') {
                        label.classList.add('bg-emerald-500/20', 'border-emerald-500');
                        label.classList.remove('border-white/10');
                    } else {
                        label.classList.add('bg-red-500/20', 'border-red-500');
                        label.classList.remove('border-white/10');
                    }
                }
                if(radio.value === '1') {
                     label.innerHTML += ' <i class="fas fa-check-circle text-emerald-400 ml-auto text-xl"></i>';
                }
                radio.disabled = true; // prevent resubmit
            });
            
            submitBtn.style.display = 'none';
            
            resultBox.classList.remove('hidden');
            resultBox.innerHTML = `
                <div class="text-6xl font-head font-bold ${passed ? 'text-emerald-400' : 'text-red-400'} mb-4">${score}%</div>
                <div class="text-white text-lg font-medium">${correct} bonne(s) réponse(s) sur ${total}</div>
                <div class="mt-6 p-4 ${passed ? 'bg-emerald-500/20 border-emerald-500/50' : 'bg-red-500/20 border-red-500/50'} border rounded-xl shadow-[0_0_20px_rgba(0,0,0,0.1)]">
                    <span class="text-lg font-bold ${passed ? 'text-emerald-300' : 'text-red-300'}">
                        ${passed ? '🎉 Félicitations ! Vous avez validé la formation !' : '⚠️ Vous n\'avez pas atteint le score requis. Révisez et réessayez !'}
                    </span>
                </div>
            `;
        }

        // Simple Tab Switcher logic
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
            
            event.target.classList.add('active');
            document.getElementById('tab-' + tabId).style.display = 'block';
        }
    </script>
</body>
</html>
