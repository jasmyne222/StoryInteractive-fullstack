<script setup>
import { ref, onMounted } from 'vue';
import { storageService } from '../services/storageService';
import { useFetchJson } from '../composables/useFetchJson'
import ErrorHandler from '../components/ErrorHandler.vue'

const props = defineProps({
    storyId: {
        type: [Number, String],
        required: true
    }
})

const emit = defineEmits(['return-to-dashboard'])
const chapter = ref(null)
const choices = ref([])
const loading = ref(true)
const error = ref(null)
const history = ref([])
const progress = ref(0)

onMounted(async () => {
    await loadFirstChapter()
})

async function loadFirstChapter() {
    try {
        loading.value = true;
        const { fetchJson } = useFetchJson();
        
        console.log('Loading first chapter for story:', props.storyId); 
        
        const chapterData = await fetchJson(`/api/v1/stories/${props.storyId}/first-chapter`);
        
        console.log('Chapter data received:', chapterData); 
        
        if (chapterData) {
            chapter.value = chapterData;
            choices.value = chapterData.choices || [];
            updateProgress();
        }
    } catch (err) {
        console.error('Error loading first chapter:', err);
        error.value = "Erreur lors du chargement du chapitre";
    } finally {
        loading.value = false;
    }
}

async function makeChoice(choice) {
    try {
        if (!choice.next_chapter_id) {
            emit('return-to-dashboard')
            return
        }

        history.value.push({
            chapter: chapter.value,
            choices: choices.value,
            choiceId: choice.id
        })

        loading.value = true
        const { fetchJson } = useFetchJson()
        
        const chapterData = await fetchJson(`/api/v1/chapters/${choice.next_chapter_id}`)
        
        if (chapterData) {
            chapter.value = chapterData
            choices.value = chapterData.choices || []
            updateProgress()
            // Sauvegarder la progression après chaque choix
            await saveProgress()
        }
    } catch (err) {
        error.value = "Erreur lors du chargement du prochain chapitre"
    } finally {
        loading.value = false
    }
}

function goBack() {
    if (history.value.length > 0) {
        const previousState = history.value.pop()
        chapter.value = previousState.chapter
        choices.value = previousState.choices
        updateProgress()
    }
}

function updateProgress() {
    const totalChapters = 12
    const currentChapter = chapter.value?.chapter_number || 1
    progress.value = (currentChapter / totalChapters) * 100
}

function retryOperation() {
    error.value = null
    loadFirstChapter()
}

function dismissError() {
    error.value = null
}

async function saveProgress() {
    try {
        // Sauvegarde locale
        const progressData = {
            story_id: props.storyId,
            chapter_id: chapter.value.id,
            choices_made: history.value.map(h => h.choiceId),
            timestamp: Date.now()
        };
        
        // Sauvegarder dans localStorage
        storageService.saveProgress(progressData);

        // Tenter la sauvegarde backend
        try {
            const response = await fetch('/api/v1/progress', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify(progressData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || 'Failed to save progress');
            }

            // Notification de succès
            emit('show-notification', {
                message: 'Progression sauvegardée',
                type: 'success',
                timeout: 3000
            });
        } catch (err) {
            console.warn('Backend save failed, using local storage only:', err);
            emit('show-notification', {
                message: 'Progression sauvegardée localement',
                type: 'warning',
                timeout: 3000
            });
        }
    } catch (err) {
        console.error('Failed to save progress:', err);
        error.value = "Erreur lors de la sauvegarde de la progression";
        emit('show-notification', {
            message: 'Erreur lors de la sauvegarde',
            type: 'error',
            timeout: 5000
        });
    }
}

// Ajout d'une fonction pour charger la progression
async function loadSavedProgress() {
    const savedProgress = storageService.loadProgress(props.storyId);
    if (savedProgress) {
        try {
            loading.value = true;
            const { fetchJson } = useFetchJson();
            
            // Charger le chapitre sauvegardé
            const chapterData = await fetchJson(`/api/v1/chapters/${savedProgress.chapter_id}`);
            
            if (chapterData) {
                chapter.value = chapterData;
                choices.value = chapterData.choices || [];
                // Restaurer l'historique
                history.value = savedProgress.choices_made.map(choiceId => ({
                    choiceId,
                    // Vous pouvez ajouter plus d'informations si nécessaire
                }));
                updateProgress();
            }
        } catch (err) {
            console.error('Error loading saved progress:', err);
            // Si échec du chargement, on commence une nouvelle partie
            loadFirstChapter();
        } finally {
            loading.value = false;
        }
    } else {
        // Pas de sauvegarde trouvée, on commence une nouvelle partie
        loadFirstChapter();
    }
}

// Charger la progression au montage du composant
onMounted(async () => {
    await loadSavedProgress();
});

function resetProgress() {
    if (confirm('Êtes-vous sûr de vouloir recommencer ? Toute progression sera perdue.')) {
        storageService.clearProgress();
        history.value = [];
        loadFirstChapter();
        updateProgress();
    }
}
</script>

<template>
    <div class="relative max-w-3xl mx-auto p-4">
        <ErrorHandler 
            :error="error"
            :onRetry="retryOperation"
            :onDismiss="dismissError"
        />

        <!-- Barre de progression -->
        <div class="bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-dating-primary h-2.5 rounded-full transition-all duration-500"
                 :style="{ width: `${progress}%` }">
            </div>
        </div>

        <!-- Boutons de navigation -->
        <div class="flex justify-between items-center mb-4">
            <button @click="goBack" 
                    :disabled="!history.length"
                    :class="['px-4 py-2 rounded-lg transition-colors',
                            history.length ? 'bg-dating-primary text-white hover:bg-dating-primary/90' 
                                        : 'bg-gray-300 text-gray-500 cursor-not-allowed']">
                ← Retour
            </button>
            
            <button @click="resetProgress"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Recommencer
            </button>
            
            <button @click="$emit('return-to-dashboard')"
                    class="px-4 py-2 bg-dating-primary text-white rounded-lg hover:bg-dating-primary/90">
                Quitter l'histoire
            </button>
        </div>

        <!-- Contenu -->
        <div v-if="loading" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-dating-primary border-t-transparent mx-auto"></div>
            <p class="mt-4 text-gray-600">Chargement...</p>
        </div>

        <div v-else-if="chapter" class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <p class="text-gray-700 leading-relaxed text-lg">
                {{ chapter.content }}
            </p>

            <div v-if="choices.length" class="space-y-4 mt-8">
                <button v-for="choice in choices" 
                        :key="choice.id"
                        @click="makeChoice(choice)"
                        class="w-full p-4 text-left rounded-lg border-2 border-dating-primary/20 
                               hover:border-dating-primary hover:bg-dating-primary/5 
                               transition-all duration-200">
                    {{ choice.text }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.chapter-view {
  max-width: 800px;
  margin: 2rem auto;
  padding: 2rem;
}

.chapter-content {
  background: var(--bg-white);
  border-radius: var(--border-radius-lg);
  padding: 2rem;
  box-shadow: var(--shadow-lg);
}

.chapter-content h2 {
  color: var(--primary);
  font-size: 1.5rem;
  margin-bottom: 1.5rem;
  font-weight: 600;
}

.chapter-content p {
  font-size: 1.125rem;
  line-height: 1.8;
  color: var(--text-dark);
  margin-bottom: 2rem;
}

.choices {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.choice-btn {
  background: var(--bg-white);
  border: 2px solid var(--primary-light);
  padding: 1rem 1.5rem;
  border-radius: var(--border-radius-md);
  font-size: 1rem;
  color: var(--primary);
  cursor: pointer;
  transition: all var(--transition-normal);
}

.choice-btn:hover {
  background: var(--primary);
  color: var(--text-light);
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.loading {
  text-align: center;
  padding: 4rem 2rem;
}

.spinner {
  width: 40px;
  height: 40px;
  margin: 0 auto 1rem;
  border: 3px solid var(--bg-light);
  border-top-color: var(--primary);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error {
  text-align: center;
  color: var(--danger);
  padding: 2rem;
}

.retry-btn {
  background: var(--primary);
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: var(--border-radius-md);
  border: none;
  margin-top: 1rem;
  cursor: pointer;
  transition: all var(--transition-normal);
}

.retry-btn:hover {
  background: var(--primary-dark);
  transform: translateY(-2px);
}

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}

@media (max-width: 768px) {
  .chapter-view {
    padding: 1rem;
    margin: 1rem auto;
  }

  .chapter-content {
    padding: 1.5rem;
  }
}
</style>