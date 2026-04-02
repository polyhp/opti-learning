@extends('layouts.formateur')

@section('title', 'Modifier la Formation - OptiLearning')

@section('content')
<div class="w-full max-w-5xl mx-auto">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('formateur.courses.show', $course) }}" class="text-navy-500 hover:text-orange-500 flex items-center mb-2 font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la formation
            </a>
            <h1 class="text-3xl font-head font-bold text-navy-900">Modifier : {{ $course->title }}</h1>
            <p class="text-slate-500 mt-1">Mettez à jour les informations et le contenu. La formation repassera en "Attente de validation".</p>
        </div>
        <div class="hidden sm:block">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center border-2 border-orange-100 shadow-inner">
                <i class="fas fa-pen-nib text-2xl text-orange-500"></i>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Il y a des erreurs dans votre formulaire :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('formateur.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="courseForm" onsubmit="return validateQuizQuestions(event)">
        @csrf
        @method('PUT')
        
        <!-- SECTION 1: Informations Générales -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold mr-4">1</div>
                <h2 class="text-xl font-head font-bold text-navy-900">Informations Générales</h2>
            </div>
            <div class="p-8 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Titre de la formation <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $course->title) }}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all placeholder-slate-400">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Catégorie <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all text-slate-700">
                            <option value="">Sélectionnez une catégorie...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Image de couverture (Miniature) <span class="text-slate-400 font-normal ml-1">(Laissez vide pour conserver l'actuelle)</span></label>
                        <input type="file" name="thumbnail" accept="image/*" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 text-sm text-slate-500 focus:outline-none mb-2">
                        @if($course->thumbnail)
                        <div class="flex items-center text-sm text-emerald-600"><i class="fas fa-check-circle mr-1"></i> Miniature actuelle {{ asset($course->thumbnail) }}</div>
                        @endif
                    </div>
                    
                    <div class="bg-orange-50/50 p-4 rounded-xl border border-orange-100">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Vidéo de couverture <span class="bg-orange-500 text-white px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider ml-2 shadow-sm">Nouveau !</span>
                            <span class="text-slate-500 font-normal ml-1 text-xs">(Laissez vide pour conserver l'actuelle)</span>
                        </label>
                        <input type="file" name="cover_video" accept="video/*" class="w-full px-4 py-2 bg-white border border-orange-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-navy-900 file:text-white hover:file:bg-navy-800 text-sm text-slate-600 focus:outline-none mb-2 transition-all">
                        @if($course->cover_video)
                        <div class="flex items-center text-sm text-emerald-600"><i class="fas fa-check-circle mr-1"></i> Vidéo actuelle {{ asset($course->cover_video) }}</div>
                        @else
                        <div class="flex items-center text-sm text-slate-400"><i class="fas fa-times-circle mr-1"></i> Aucune vidéo pour l'instant</div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Prix (FCFA) <span class="text-xs text-slate-400 font-normal ml-1">Mettre 0 pour Gratuit</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-coins text-slate-400"></i>
                            </div>
                            <input type="number" name="price" min="0" value="{{ old('price', $course->price) }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Durée estimée (minutes) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-slate-400"></i>
                            </div>
                            <input type="number" name="duration_minutes" min="1" value="{{ old('duration_minutes', $course->duration_minutes) }}" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description complète <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="5" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all placeholder-slate-400">{{ old('description', $course->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Contenu Vidéos & Leçons -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-navy-100 text-navy-700 flex items-center justify-center font-bold mr-4">2</div>
                    <div>
                        <h2 class="text-xl font-head font-bold text-navy-900">Vidéos & Chapitres</h2>
                        <p class="text-xs text-slate-500 mt-1">Laissez le champ fichier vide pour conserver la vidéo actuelle.</p>
                    </div>
                </div>
                <button type="button" onclick="addLesson()" class="bg-navy-50 hover:bg-navy-100 text-navy-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors border border-navy-200">
                    <i class="fas fa-plus mr-1"></i> Ajouter une vidéo
                </button>
            </div>
            
            <div class="p-8 bg-slate-50/30" id="lessons-container">
                <!-- Lessons injected by JS -->
            </div>
        </div>

        <!-- SECTION 3: Quiz (Optionnel) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold mr-4">3</div>
                    <div>
                        <h2 class="text-xl font-head font-bold text-navy-900">Quiz d'Évaluation <span class="text-sm font-bold text-red-500 ml-2">(Obligatoire)</span></h2>
                        <p class="text-xs text-slate-500 mt-1">Configurez un quiz global et obligatoire pour valider la formation.</p>
                    </div>
                </div>
            </div>
            
            <div id="quiz-wrapper" class="block">
                <div class="p-8 border-b border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Titre du Quiz</label>
                            <input type="text" name="quiz_title" id="quiz_title" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Ex: QCM Final de Validation">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Score requis pour réussir (/20)</label>
                            <input type="number" name="quiz_passing_score" id="quiz_passing_score" min="1" max="20" value="10" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none text-slate-700">
                        </div>
                    </div>
                </div>
                
                <div class="p-8 bg-slate-50/30" id="questions-container">
                    <div class="text-center py-6" id="empty-questions-msg">
                        <i class="fas fa-question-circle text-4xl text-slate-200 mb-3"></i>
                        <p class="text-slate-500 text-sm mb-4">Aucune question ajoutée au quiz.</p>
                        <button type="button" onclick="addQuestion()" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-6 py-2.5 rounded-xl font-medium text-sm transition-colors shadow-sm">
                            <i class="fas fa-plus mr-2"></i> Ajouter la 1ère Question
                        </button>
                    </div>
                </div>
                
                <div class="px-8 py-4 bg-emerald-50/30 border-t border-emerald-100 text-right hidden" id="add-more-questions-btn">
                    <button type="button" onclick="addQuestion()" class="text-emerald-600 hover:text-emerald-700 font-medium text-sm transition-colors">
                        <i class="fas fa-plus flex-shrink-0 mr-1"></i> Ajouter une autre question
                    </button>
                </div>
            </div>
        </div>
        
        <!-- SECTION 4: Quiz de Rattrapage (Optionnel) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold mr-4">4</div>
                    <div>
                        <h2 class="text-xl font-head font-bold text-navy-900">Quiz de Rattrapage <span class="text-sm font-normal text-slate-400 ml-2">(Optionnel)</span></h2>
                        <p class="text-xs text-slate-500 mt-1">Dernière chance : questions différentes si l'apprenant échoue à l'évaluation finale.</p>
                    </div>
                </div>
                
                <label class="relative inline-flex items-center cursor-pointer">
                  <input type="checkbox" id="enableMakeupToggle" class="sr-only peer" onchange="toggleMakeupSection(this)">
                  <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                  <span class="ml-3 text-sm font-medium text-slate-600" id="makeupStatusText">Désactivé</span>
                </label>
            </div>
            
            <div id="makeup-wrapper" class="hidden">
                <div class="p-8 border-b border-slate-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Titre du Rattrapage</label>
                            <input type="text" name="makeup_quiz_title" id="makeup_quiz_title" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none" placeholder="Ex: Rattrapage - QCM Final">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Score requis pour réussir (/20)</label>
                            <input type="number" name="makeup_quiz_passing_score" id="makeup_quiz_passing_score" min="1" max="20" value="10" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none text-slate-700">
                        </div>
                    </div>
                </div>
                
                <div class="p-8 bg-slate-50/30" id="makeup-questions-container">
                    <div class="text-center py-6" id="empty-makeup-questions-msg">
                        <i class="fas fa-life-ring text-4xl text-slate-200 mb-3"></i>
                        <p class="text-slate-500 text-sm mb-4">Aucune question ajoutée au rattrapage.</p>
                        <button type="button" onclick="addMakeupQuestion()" class="bg-red-50 hover:bg-red-100 text-red-600 px-6 py-2.5 rounded-xl font-medium text-sm transition-colors shadow-sm cursor-pointer">
                            <i class="fas fa-plus mr-2"></i> Ajouter la 1ère Question
                        </button>
                    </div>
                </div>
                
                <div class="px-8 py-4 bg-red-50/30 border-t border-red-100 text-right hidden" id="add-more-makeup-questions-btn">
                    <button type="button" onclick="addMakeupQuestion()" class="text-red-500 hover:text-red-600 font-medium text-sm transition-colors cursor-pointer">
                        <i class="fas fa-plus flex-shrink-0 mr-1"></i> Ajouter une autre question
                    </button>
                </div>
            </div>

        <!-- Submit Button -->
        <div class="flex flex-col sm:flex-row gap-4 justify-end pt-4 pb-12">
            <a href="{{ route('formateur.courses.show', $course) }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-xl font-bold transition-all text-center flex items-center justify-center text-lg">
                Annuler
            </a>
            <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-10 py-4 rounded-xl font-bold shadow-xl shadow-orange-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center text-lg">
                <i class="fas fa-save mr-3 text-xl"></i>
                Enregistrer & Soumettre
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    let lessonCount = 0;
    let questionCount = 0;
    let makeupQuestionCount = 0;

    const existingLessons = @json($course->lessons);
    const existingQuizzes = @json($course->quizzes);

    function initExistingData() {
        // Init lessons
        if (existingLessons.length > 0) {
            existingLessons.forEach(lesson => {
                addLesson(lesson.id, lesson.title, lesson.file_path);
            });
        }
        
        // Init Standard Quiz
        const stdQuiz = existingQuizzes.find(q => q.type === 'standard');
        if (stdQuiz) {
            document.getElementById('quiz_title').value = stdQuiz.title;
            document.getElementById('quiz_passing_score').value = stdQuiz.passing_score;
            if (stdQuiz.questions) {
                stdQuiz.questions.forEach(q => {
                    addQuestion(q.question_text, q.options);
                });
            }
        }
        
        // Init Makeup Quiz
        const makeupQuiz = existingQuizzes.find(q => q.type === 'makeup');
        if (makeupQuiz) {
            document.getElementById('enableMakeupToggle').checked = true;
            toggleMakeupSection(document.getElementById('enableMakeupToggle'));
            document.getElementById('makeup_quiz_title').value = makeupQuiz.title;
            document.getElementById('makeup_quiz_passing_score').value = makeupQuiz.passing_score;
            if (makeupQuiz.questions) {
                makeupQuiz.questions.forEach(q => {
                    addMakeupQuestion(q.question_text, q.options);
                });
            }
        }
        
        // Final sanity fix: ensure at least one question exists for UI display
        if (questionCount === 0) {
            addQuestion();
        }
    }
    
    function validateQuizQuestions(event) {
        const qCount = document.querySelectorAll('.question-block').length;
        if (qCount === 0) {
            event.preventDefault();
            alert('Vous devez obligatoirement ajouter au moins une question à l\'Évaluation Finale pour pouvoir soumettre.');
            document.getElementById('questions-container').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    function addLesson(lessonData = null) {
        const container = document.getElementById('lessons-container');
        const isExisting = lessonData !== null;
        
        let fileInputHtml = '';
        if (isExisting) {
            fileInputHtml = `
                <input type="hidden" name="lessons[${lessonCount}][id]" value="${lessonData.id}">
                <label class="block text-sm font-medium text-slate-700 mb-2">Fichier (Vidéo, PDF...) <span class="text-xs text-slate-400 font-normal">(Optionnel, uploadez un fichier pour le remplacer)</span></label>
                <input type="file" name="lessons[${lessonCount}][file]" class="w-full px-4 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-600 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-navy-50 file:text-navy-700 hover:file:bg-navy-100 cursor-pointer focus:outline-none">
                <div class="mt-2 text-xs text-emerald-600"><i class="fas fa-check-circle"></i> Fichier actuel conservé</div>
            `;
        } else {
            fileInputHtml = `
                <label class="block text-sm font-medium text-slate-700 mb-2">Fichier (Vidéo, PDF...) <span class="text-red-500">*</span></label>
                <input type="file" name="lessons[${lessonCount}][file]" required class="w-full px-4 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-600 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:bg-navy-50 file:text-navy-700 hover:file:bg-navy-100 cursor-pointer focus:outline-none">
            `;
        }

        const titleVal = isExisting ? lessonData.title.replace(/"/g, '&quot;') : '';

        const lessonHtml = `
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm mb-4 relative group lesson-block" data-index="${lessonCount}">
                <div class="absolute -left-3 -top-3 w-8 h-8 bg-navy-700 text-white rounded-full flex items-center justify-center font-bold border-4 border-white shadow-sm lesson-number"></div>
                <button type="button" onclick="this.closest('.lesson-block').remove(); updateLessonNumbers();" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors hidden group-hover:block" title="Supprimer">
                    <i class="fas fa-trash-alt"></i>
                </button>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Titre de la vidéo/leçon <span class="text-red-500">*</span></label>
                        <input type="text" name="lessons[${lessonCount}][title]" value="${titleVal}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-navy-500 outline-none" placeholder="Ex: Chapitre suivant">
                    </div>
                    <div>
                        ${fileInputHtml}
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', lessonHtml);
        lessonCount++;
        updateLessonNumbers();
    }

    function updateLessonNumbers() {
        document.querySelectorAll('.lesson-block').forEach((block, index) => {
            block.querySelector('.lesson-number').textContent = index + 1;
        });
    }

    function toggleQuizSection(checkbox) {
        const wrapper = document.getElementById('quiz-wrapper');
        const text = document.getElementById('quizStatusText');
        const titleInput = document.getElementById('quiz_title');
        
        if (checkbox.checked) {
            wrapper.classList.remove('hidden');
            text.textContent = 'Activé';
            text.classList.add('text-emerald-600');
            titleInput.setAttribute('required', 'required');
        } else {
            wrapper.classList.add('hidden');
            text.textContent = 'Désactivé';
            text.classList.remove('text-emerald-600');
            titleInput.removeAttribute('required');
        }
    }

    function addQuestion(qData = null) {
        document.getElementById('empty-questions-msg').style.display = 'none';
        document.getElementById('add-more-questions-btn').classList.remove('hidden');
        
        const container = document.getElementById('questions-container');
        const qIndex = questionCount++;
        
        const isExisting = qData !== null;
        const textVal = isExisting ? qData.question_text.replace(/"/g, '&quot;') : '';
        
        let optionsHtml = '';
        if (isExisting && qData.options) {
            qData.options.forEach((opt, idx) => {
                const isChecked = opt.is_correct ? 'checked' : '';
                const optVal = opt.option_text.replace(/"/g, '&quot;');
                optionsHtml += `
                    <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-emerald-200 transition-colors">
                        <input type="radio" name="questions[${qIndex}][correct_option]" value="${idx}" ${isChecked} required class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500 cursor-pointer">
                        <input type="text" name="questions[${qIndex}][options][]" value="${optVal}" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option ${idx + 1}">
                    </div>
                `;
            });
        } else {
            // Default 3 options
            optionsHtml = `
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-emerald-200 transition-colors">
                    <input type="radio" name="questions[${qIndex}][correct_option]" value="0" required class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500 cursor-pointer">
                    <input type="text" name="questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 1">
                </div>
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-emerald-200 transition-colors">
                    <input type="radio" name="questions[${qIndex}][correct_option]" value="1" required class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500 cursor-pointer">
                    <input type="text" name="questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 2">
                </div>
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-emerald-200 transition-colors">
                    <input type="radio" name="questions[${qIndex}][correct_option]" value="2" required class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500 cursor-pointer">
                    <input type="text" name="questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 3">
                </div>
            `;
        }

        const questionHtml = `
            <div class="bg-white p-6 rounded-xl border border-emerald-100 shadow-sm mb-6 relative group question-block">
                <div class="absolute -left-3 -top-3 w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center font-bold border-4 border-white shadow-sm question-number">Q${qIndex+1}</div>
                <button type="button" onclick="this.closest('.question-block').remove(); checkEmptyQuestions();" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors" title="Supprimer la question">
                    <i class="fas fa-times"></i>
                </button>
                
                <div class="pl-4">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-navy-900 mb-2">L'intitulé de la question <span class="text-red-500">*</span></label>
                        <input type="text" name="questions[${qIndex}][text]" value="${textVal}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Posez votre question...">
                    </div>
                    
                    <div class="space-y-3 mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Réponses (Cochez la bonne réponse) <span class="text-red-500">*</span></label>
                        ${optionsHtml}
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', questionHtml);
        updateQuestionNumbers();
    }
    
    function updateQuestionNumbers() {
        document.querySelectorAll('.question-block').forEach((block, index) => {
            block.querySelector('.question-number').textContent = `Q${index + 1}`;
        });
    }

    function checkEmptyQuestions() {
        if(document.querySelectorAll('.question-block').length === 0) {
            document.getElementById('empty-questions-msg').style.display = 'block';
            document.getElementById('add-more-questions-btn').classList.add('hidden');
        }
        updateQuestionNumbers();
    }

    function toggleMakeupSection(checkbox) {
        const wrapper = document.getElementById('makeup-wrapper');
        const text = document.getElementById('makeupStatusText');
        const titleInput = document.getElementById('makeup_quiz_title');
        
        if (checkbox.checked) {
            wrapper.classList.remove('hidden');
            text.textContent = 'Activé';
            text.classList.add('text-red-600');
            titleInput.setAttribute('required', 'required');
        } else {
            wrapper.classList.add('hidden');
            text.textContent = 'Désactivé';
            text.classList.remove('text-red-600');
            titleInput.removeAttribute('required');
        }
    }

    function addMakeupQuestion(qData = null) {
        document.getElementById('empty-makeup-questions-msg').style.display = 'none';
        document.getElementById('add-more-makeup-questions-btn').classList.remove('hidden');
        
        const container = document.getElementById('makeup-questions-container');
        const qIndex = makeupQuestionCount++;
        
        const isExisting = qData !== null;
        const textVal = isExisting ? qData.question_text.replace(/"/g, '&quot;') : '';
        
        let optionsHtml = '';
        if (isExisting && qData.options) {
            qData.options.forEach((opt, idx) => {
                const isChecked = opt.is_correct ? 'checked' : '';
                const optVal = opt.option_text.replace(/"/g, '&quot;');
                optionsHtml += `
                    <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-red-200 transition-colors">
                        <input type="radio" name="makeup_questions[${qIndex}][correct_option]" value="${idx}" ${isChecked} required class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500 cursor-pointer">
                        <input type="text" name="makeup_questions[${qIndex}][options][]" value="${optVal}" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option ${idx + 1}">
                    </div>
                `;
            });
        } else {
            optionsHtml = `
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-red-200 transition-colors">
                    <input type="radio" name="makeup_questions[${qIndex}][correct_option]" value="0" required class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500 cursor-pointer">
                    <input type="text" name="makeup_questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 1">
                </div>
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-red-200 transition-colors">
                    <input type="radio" name="makeup_questions[${qIndex}][correct_option]" value="1" required class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500 cursor-pointer">
                    <input type="text" name="makeup_questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 2">
                </div>
                <div class="flex items-center space-x-3 bg-slate-50 p-2 rounded-lg border border-slate-100 hover:border-red-200 transition-colors">
                    <input type="radio" name="makeup_questions[${qIndex}][correct_option]" value="2" required class="w-5 h-5 text-red-600 border-slate-300 focus:ring-red-500 cursor-pointer">
                    <input type="text" name="makeup_questions[${qIndex}][options][]" required class="flex-grow bg-transparent border-0 focus:ring-0 px-2 outline-none text-sm placeholder-slate-400" placeholder="Option 3">
                </div>
            `;
        }

        const questionHtml = `
            <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm mb-6 relative group makeup-question-block">
                <div class="absolute -left-3 -top-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center font-bold border-4 border-white shadow-sm makeup-question-number">Q${qIndex+1}</div>
                <button type="button" onclick="this.closest('.makeup-question-block').remove(); checkEmptyMakeupQuestions();" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors" title="Supprimer la question">
                    <i class="fas fa-times"></i>
                </button>
                
                <div class="pl-4">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-navy-900 mb-2">L'intitulé de la question <span class="text-red-500">*</span></label>
                        <input type="text" name="makeup_questions[${qIndex}][text]" value="${textVal}" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none" placeholder="Posez votre question...">
                    </div>
                    
                    <div class="space-y-3 mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Réponses (Cochez la bonne réponse) <span class="text-red-500">*</span></label>
                        ${optionsHtml}
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', questionHtml);
        updateMakeupQuestionNumbers();
    }
    
    function updateMakeupQuestionNumbers() {
        document.querySelectorAll('.makeup-question-block').forEach((block, index) => {
            block.querySelector('.makeup-question-number').textContent = `Q${index + 1}`;
        });
    }

    function checkEmptyMakeupQuestions() {
        if(document.querySelectorAll('.makeup-question-block').length === 0) {
            document.getElementById('empty-makeup-questions-msg').style.display = 'block';
            document.getElementById('add-more-makeup-questions-btn').classList.add('hidden');
        }
        updateMakeupQuestionNumbers();
    }

    // Load data on page load
    document.addEventListener('DOMContentLoaded', initExistingData);
</script>
@endpush
@endsection
