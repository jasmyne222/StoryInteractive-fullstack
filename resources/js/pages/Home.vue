<template>
  <div>
    <h1>Choisis ton histoire</h1>

    <div v-if="loading">Chargement...</div>
    <div v-else-if="error">Erreur : {{ error.statusText }}</div>

    <ul v-else>
      <li v-for="story in stories" :key="story.id" class="story-card">
        <h2>{{ story.title }}</h2>
        <p>{{ story.summary }}</p>
        <button @click="startStory(story.id)">Commencer</button>
      </li>
    </ul>

    <ChapterView
      v-if="firstChapter"
      :initialChapter="firstChapter"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { fetchJson } from '@/utils/fetchJson'
import ChapterView from '@/pages/ChapterView.vue'

const stories = ref([])
const error = ref(null)
const loading = ref(false)
const firstChapter = ref(null)

async function loadStories() {
  loading.value = true
  try {
    const result = await fetchJson('/stories').request
    stories.value = result
  } catch (err) {
    error.value = err
  } finally {
    loading.value = false
  }
}

async function startStory(storyId) {
  firstChapter.value = null
  try {
    const result = await fetchJson(`/stories/${storyId}/first-chapter`).request
    firstChapter.value = result
  } catch (err) {
    error.value = err
  }
}

loadStories()
</script>

<style scoped>
h1 {
  font-size: 2rem;
  margin-bottom: 2rem;
}

.story-card {
  border: 1px solid #ccc;
  border-radius: 12px;
  padding: 1rem;
  margin-bottom: 1.5rem;
  background-color: #f9f9f9;
}

.story-card h2 {
  margin: 0 0 0.5rem 0;
}

.story-card button {
  margin-top: 0.5rem;
  background-color: #10b981;
  color: white;
  padding: 0.6rem 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.story-card button:hover {
  background-color: #059669;
}
</style>
