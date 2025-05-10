<template>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error">Erreur : {{ error.statusText }}</div>
    <div v-else>
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
  
  const props = defineProps({
    chapterId: {
      type: Number,
      required: true
    }
  })
  
  const chapter = ref(null)
  const loading = ref(false)
  const error = ref(null)
  
  async function loadChapter(id) {
    loading.value = true
    chapter.value = null
    error.value = null
  
    try {
      const result = await fetchJson(`/chapters/${id}`).request
      chapter.value = result
    } catch (err) {
      error.value = err
    } finally {
      loading.value = false
    }
  }
  
  watch(() => props.chapterId, (id) => {
    if (id) loadChapter(id)
  }, { immediate: true })
  </script>
  