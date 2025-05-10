<template>
  <div v-for="story in stories" :key="story.id" class="story-card">
    <h2>{{ story.title }}</h2>
    <p>{{ story.summary }}</p>
    <button @click="start(story.id)">Commencer</button>
  </div>
</template>

<script setup>
import { fetchJson } from '@/utils/fetchJson'
import { ref, onMounted } from 'vue'
// import { emit } from 'vue'

const emit = defineEmits(['start'])

const stories = ref([])

async function fetchStories() {
  const result = await fetchJson('/stories').request
  stories.value = result
}

function start(storyId) {
  fetchJson(`/stories/${storyId}/first-chapter`).request
    .then(chapter => {
      emit('start', chapter.id)
    })
    .catch(err => {
      console.error('Erreur :', err)
    })
}

onMounted(fetchStories)
</script>
