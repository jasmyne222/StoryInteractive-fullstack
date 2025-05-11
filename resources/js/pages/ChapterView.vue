<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    chapterId: {
        type: Number,
        required: true
    }
})

const emit = defineEmits(['return-to-dashboard'])
const chapter = ref(null)
const choices = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    await loadFirstChapter()
})

async function loadFirstChapter() {
    try {
        loading.value = true
        const response = await fetch(`/api/stories/${props.chapterId}/first-chapter`)
        if (!response.ok) throw new Error('Failed to load chapter')
        
        const data = await response.json()
        chapter.value = data
        choices.value = data.choices
    } catch (err) {
        error.value = err.message
        console.error('Error:', err)
    } finally {
        loading.value = false
    }
}

async function loadChapter(chapterId) {
    try {
        loading.value = true
        const response = await fetch(`/api/chapters/${chapterId}`)
        if (!response.ok) throw new Error('Failed to load chapter')
        
        const data = await response.json()
        chapter.value = data
        choices.value = data.choices
    } catch (err) {
        error.value = err.message
        console.error('Error:', err)
    } finally {
        loading.value = false
    }
}

async function makeChoice(choice) {
  try {
    const response = await fetch('/api/choices', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ choice_id: choice.id })
    })
    
    if (!response.ok) throw new Error('Failed to process choice')
    
    // Au lieu d'utiliser find, chargeons directement le prochain chapitre
    if (choice.next_chapter_id) {
      await loadChapter(choice.next_chapter_id)
    } else {
      emit('return-to-dashboard')
    }
  } catch (err) {
    error.value = err.message
    console.error('Error:', err)
  }
}
</script>

<template>
  <div class="max-w-3xl mx-auto space-y-8">
    <button @click="$emit('return-to-dashboard')"
            class="flex items-center text-romance-600 hover:text-romance-700 transition-colors">
      <span class="mr-2">←</span> Return to Scenarios
    </button>
    
    <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
      <h2 class="text-2xl font-bold text-romance-800">
        {{ chapter?.title }}
      </h2>
      
      <p class="text-gray-700 leading-relaxed text-lg">
        {{ chapter?.content }}
      </p>
      
      <div class="space-y-4 mt-8">
        <button v-for="choice in choices" 
                :key="choice.id"
                @click="makeChoice(choice)"
                class="w-full p-4 text-left rounded-lg border-2 border-romance-200 
                       hover:border-romance-400 hover:bg-romance-50 transition-all
                       focus:outline-none focus:ring-2 focus:ring-romance-500">
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