<template>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error">Erreur : {{ error.statusText }}</div>
    <div v-else-if="chapter">
      <h1>Chapitre {{ chapter.chapter_number }}</h1>
      <p>{{ chapter.content }}</p>
  
      <ul>
        <li v-for="choice in chapter.choices" :key="choice.id">
          <button @click="loadChapter(choice.next_chapter_id)">
            {{ choice.text }}
          </button>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue'
  import { fetchJson } from '@/utils/fetchJson'
  
  // 👇 On récupère la prop passée par le parent
  const props = defineProps({
    initialChapter: Object
  })
  
  const chapter = ref(null)
  const error = ref(null)
  const loading = ref(false)
  
  async function loadChapter(id) {
    loading.value = true
    error.value = null
    chapter.value = null
  
    try {
      const result = await fetchJson(`/chapters/${id}`).request
      chapter.value = result
    } catch (err) {
      error.value = err
    } finally {
      loading.value = false
    }
  }
  
  // 👇 Watcher : quand la prop change, on l'affiche
  watch(() => props.initialChapter, (newVal) => {
    if (newVal) {
      chapter.value = newVal
    }
  }, { immediate: true })
  </script>
  
  <style scoped>
h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
}

p {
  font-size: 1.2rem;
  line-height: 1.6;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  margin-bottom: 1rem;
}

button {
  background-color: #3b82f6;
  color: white;
  padding: 0.8rem 1.2rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #2563eb;
}
</style>
