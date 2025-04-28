<script setup>
import { ref, watchEffect } from 'vue';
import { useFetchJson } from '@/composables/useFetchJson';

const { data: test } = useFetchJson('test');
const { data: delTest, error: delError} = useFetchJson({url: 'test', method: 'DELETE' });

const time = ref(null);
const timeLoading = ref(false);
const timeError = ref(null);
let timeAbort = null;

function timeFetch() {
  const { data, error, loading, abort } = useFetchJson({
    url: 'time',
    data: { timeClient: new Date() },
  });
  timeAbort = abort;
  watchEffect(() => {
    timeError.value = error.value;
    time.value = data.value;
    timeLoading.value = loading.value;
  });
}

</script>

<template>
  <div>
    <h1>Page Example</h1>
    <p>{{ test }}</p>
    <p>{{ delTest }}</p>
    <p>{{ delError }}</p>

    <button @click="timeFetch" :disabled="timeLoading">
      Fetch time
    </button>
    <button @click="timeAbort" :disabled="!timeLoading">
      Abort
    </button>
    <p v-if="timeLoading">Loading...</p>
    <p v-if="time">{{ time }}</p>
    <p v-if="timeError">{{ timeError }}</p>
  </div>
</template>

<style scoped>

</style>