<script setup>
import { ref, onMounted } from 'vue'

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
const history = ref([]) // Pour stocker l'historique des chapitres
const progress = ref(0) // Pour la barre de progression

onMounted(() => {
    loadFirstChapter()
})

async function loadFirstChapter() {
    try {
        loading.value = true
        error.value = null
        history.value = [] // Réinitialiser l'historique
        
        const response = await fetch(`/api/stories/${props.storyId}/first-chapter`)
        const result = await response.json()
        
        if (result.success && result.data) {
            chapter.value = result.data
            choices.value = result.data.choices || []
            updateProgress()
        }
    } catch (err) {
        error.value = `Failed to load chapter: ${err.message}`
    } finally {
        loading.value = false
    }
}

async function makeChoice(choice) {
    try {
        if (!choice.next_chapter_id) {
            emit('return-to-dashboard')
            return
        }

        // Sauvegarder le chapitre actuel dans l'historique
        history.value.push({
            chapter: chapter.value,
            choices: choices.value
        })

        loading.value = true
        error.value = null

        const response = await fetch(`/api/chapters/${choice.next_chapter_id}`)
        const result = await response.json()
        
        if (result.success && result.data) {
            chapter.value = result.data
            choices.value = result.data.choices || []
            updateProgress()
        }
    } catch (err) {
        error.value = `Failed to proceed: ${err.message}`
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
    // Calculer la progression (exemple simple)
    const totalChapters = 12 // Nombre total de chapitres possibles
    const currentChapter = chapter.value.chapter_number
    progress.value = (currentChapter / totalChapters) * 100
}
</script>

<template>
    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Barre de progression -->
        <div class="bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-dating-primary h-2.5 rounded-full transition-all duration-500"
                 :style="{ width: `${progress}%` }">
            </div>
        </div>

        <!-- Boutons de navigation -->
        <div class="flex justify-between items-center">
            <button @click="goBack" 
                    :disabled="history.length === 0"
                    :class="['px-4 py-2 rounded-lg transition-colors',
                            history.length === 0 
                            ? 'bg-gray-300 text-gray-500 cursor-not-allowed' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200']">
                ← Retour
            </button>
            
            <button @click="$emit('return-to-dashboard')"
                    class="px-4 py-2 bg-dating-primary text-white rounded-lg hover:bg-dating-primary/90">
                Quitter l'histoire
            </button>
        </div>

        <!-- Chapitre et choix -->
        <div v-if="loading" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-dating-primary border-t-transparent mx-auto"></div>
            <p class="mt-4 text-gray-600">Chargement...</p>
        </div>

        <div v-else-if="error" class="text-center py-12">
            <p class="text-red-500">{{ error }}</p>
            <button @click="loadFirstChapter" 
                    class="mt-4 px-4 py-2 bg-dating-primary text-white rounded-lg hover:bg-dating-primary/90">
                Réessayer
            </button>
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