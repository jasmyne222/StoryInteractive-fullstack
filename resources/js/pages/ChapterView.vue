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

onMounted(() => {
    console.log('Mounting ChapterView with storyId:', props.storyId)
    loadFirstChapter()
})

async function loadFirstChapter() {
    try {
        loading.value = true
        error.value = null
        
        console.log('Fetching first chapter for story:', props.storyId)
        const response = await fetch(`/api/stories/${props.storyId}/first-chapter`, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        
        console.log('Response status:', response.status)
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const result = await response.json()
        console.log('API response:', result)
        
        if (result.success && result.data) {
            chapter.value = result.data
            choices.value = result.data.choices || []
            console.log('Chapter loaded:', chapter.value)
            console.log('Choices loaded:', choices.value)
        } else {
            throw new Error(result.message || 'Invalid response format')
        }
    } catch (err) {
        console.error('Error loading chapter:', err)
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

        loading.value = true
        error.value = null
        
        const response = await fetch(`/api/chapters/${choice.next_chapter_id}`, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const result = await response.json()
        console.log('Next chapter data:', result)
        
        if (result.success && result.data) {
            chapter.value = result.data
            choices.value = result.data.choices || []
        } else {
            throw new Error('Failed to load next chapter')
        }
    } catch (err) {
        console.error('Error making choice:', err)
        error.value = `Failed to proceed: ${err.message}`
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Return button -->
        <button @click="$emit('return-to-dashboard')"
                class="flex items-center text-dating-primary hover:text-dating-primary/80 transition-colors">
            <span class="mr-2">←</span> Return to Stories
        </button>

        <!-- Loading state -->
        <div v-if="loading" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-dating-primary border-t-transparent mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading chapter...</p>
        </div>

        <!-- Error state -->
        <div v-else-if="error" class="text-center py-12">
            <p class="text-red-500">{{ error }}</p>
            <button @click="loadFirstChapter"
                    class="mt-4 px-4 py-2 bg-dating-primary text-white rounded-lg hover:bg-dating-primary/90">
                Try Again
            </button>
        </div>

        <!-- Chapter content -->
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