<script setup>
import { useFetchJson } from '@/composables/useFetchJson'

// Appel à l'API /api/stories (ou adapte selon ta route réelle)
const {
  data: stories,
  error,
  loading,
} = useFetchJson('stories')
</script>

<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Choisis ton histoire</h1>

    <div v-if="loading">Chargement...</div>
    <div v-if="error" class="text-red-500">Erreur : {{ error }}</div>

    <div v-if="stories" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div
        v-for="(story, index) in stories"
        :key="story.id"
        class="p-4 rounded shadow bg-white border cursor-pointer hover:bg-blue-50"
        :class="{'opacity-50 cursor-not-allowed': index > 0}"
        @click="index === 0 && $router.push({ name: 'story', params: { id: story.id } })"
      >
        <h2 class="text-xl font-semibold">
          {{ story.title || `Histoire ${index + 1}` }}
        </h2>
        <p class="text-sm mt-2 text-gray-700">
          {{ index === 0 ? 'Une aventure interactive où chaque choix compte.' : 'Disponible prochainement' }}
        </p>
      </div>
    </div>
  </div>
</template>
