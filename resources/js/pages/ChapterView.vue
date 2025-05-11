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

async function makeChoice(choiceId) {
    try {
        const response = await fetch('/api/choices', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ choice_id: choiceId })
        })
        
        if (!response.ok) throw new Error('Failed to process choice')
        
        const choice = choices.value.find(c => c.id === choiceId)
        if (choice && choice.next_chapter_id) {
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
    <div class="chapter-view">
        <div v-if="loading" class="loading">
            <div class="spinner"></div>
            <p>Loading chapter...</p>
        </div>

        <div v-else-if="error" class="error">
            <p>{{ error }}</p>
            <button @click="loadFirstChapter">Try Again</button>
        </div>

        <div v-else-if="chapter" class="chapter-content">
            <h2>Chapter {{ chapter.chapter_number }}</h2>
            <p>{{ chapter.content }}</p>

            <div class="choices">
                <button
                    v-for="choice in choices"
                    :key="choice.id"
                    @click="makeChoice(choice.id)"
                    class="choice-btn"
                >
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