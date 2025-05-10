<template>
  <div>
    <TheHeader />
    <main>
      <Home v-if="currentView === 'home'" @start="startStory" />
      <ChapterView v-else-if="currentView === 'chapter'" :chapterId="chapterId" />
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Home from '@/pages/Home.vue'
import ChapterView from '@/pages/ChapterView.vue'
import TheHeader from '@/components/TheHeader.vue'

const currentView = ref('home')
const chapterId = ref(null)

function startStory(id) {
  chapterId.value = id
  currentView.value = 'chapter'
}
</script>
