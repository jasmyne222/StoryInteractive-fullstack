<script setup>
  import { ref } from 'vue';
  import TheHeader from '@/components/TheHeader.vue';
  import Home from '@/pages/Home.vue';
  const n = ref(1);
</script>

<template>
  <div>
    <TheHeader />
    <main>
      <Home />
    </main>
  </div>
</template>

<style scoped>

</style>