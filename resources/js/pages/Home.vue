<script setup>
import { ref, onMounted, watch } from "vue";
import TheHeader from "../components/TheHeader.vue";
import ChapterView from "../pages/ChapterView.vue"; 
import { useFetchJson } from "../composables/useFetchJson.js";

// Event emitter definition
const emit = defineEmits(["return-to-dashboard"]);

// State management
const userName = ref("");
const loading = ref(true);
const error = ref(null);
const currentChapter = ref(null);
const choices = ref([]);
const stories = ref([]);

onMounted(() => {
    loadUserProgress();
});

function loadUserProgress() {
    const { data: response, error: fetchError } = useFetchJson("/api/v1/progress");  // Ajout de v1
    watch(response, (progress) => {
        if (progress && progress.success && progress.data) {
            userName.value = progress.data.user_name || "Guest";

            if (progress.data.chapter_id >= 10) {
                loadDateEnding(progress.data.chapter_id);
                loading.value = false;
            } else if (progress.data.chapter_id) {
                loadChapter(progress.data.chapter_id);
            } else {
                loadFirstChapter();
            }
            loading.value = false;
        } else {
            console.error(fetchError);
            error.value = "Error loading progress data";
            loading.value = false;
        }
    });
}

function loadFirstChapter() {
    const { data: response, error: fetchError } = useFetchJson("/api/v1/chapters/first");  // Ajout de v1
    watch(response, (firstChapter) => {
        if (firstChapter && firstChapter.success && firstChapter.data) {
            currentChapter.value = firstChapter.data;
            loadChoicesForChapter(firstChapter.data.id);
        } else {
            console.error(fetchError);
            error.value = "Error loading first chapter";
            loading.value = false;
        }
    });
}

function loadChapter(chapterId) {
    const { data: response, error: fetchError } = useFetchJson(`/api/v1/chapters/${chapterId}`);  // Ajout de v1
    watch(response, (chapter) => {
        if (chapter && chapter.success && chapter.data) {
            currentChapter.value = chapter.data;
            loadChoicesForChapter(chapterId);
        } else {
            console.error(fetchError);
            error.value = "Error loading chapter";
            loading.value = false;
        }
    });
}

function loadChoicesForChapter(chapterId) {
    const { data: response, error: fetchError } = useFetchJson(`/api/v1/chapters/${chapterId}/choices`);  // Ajout de v1
    watch(response, (chapterChoices) => {
        if (chapterChoices && chapterChoices.success && chapterChoices.data) {
            choices.value = chapterChoices.data;
        } else {
            console.error(fetchError);
            error.value = "Error loading choices";
            loading.value = false;
        }
    });
}

function makeChoice(choice) {
    const { data: response, error: fetchError } = useFetchJson({
        url: "/api/v1/progress/update",  
        method: "PATCH",
        data: { choice_id: choice.id },
    });
    
    watch(response, (progressUpdate) => {
        if (progressUpdate && progressUpdate.success && progressUpdate.data) {
            if (progressUpdate.data.chapter_id >= 10) {
                loadDateEnding(progressUpdate.data.chapter_id);
            } else if (progressUpdate.data.chapter_id) {
                loadChapter(progressUpdate.data.chapter_id);
            }
        } else {
            console.error(fetchError);
            error.value = "Error updating progress";
        }
    });
}

function loadDateEnding(endChapterId) {
    if (endChapterId) {
        loadChapter(endChapterId);
        return;
    }

    // Default - Neutral Ending
    loadChapter(14);
}

function resetProgress() {
    const { data: response, error: fetchError } = useFetchJson({
        url: "/api/v1/progress/reset",  
        method: "PATCH",
    });

    watch(response, (resetStatus) => {
        if (resetStatus && resetStatus.success) {
            loadFirstChapter();
            loading.value = false;
        } else {
            console.error(fetchError);
            error.value = "Error resetting progress";
            loading.value = false;
        }
    });
}

function returnToDashboard() {
    emit("return-to-dashboard");
}

// Fetch stories 
const { data, error: fetchError, loading: fetchLoading, execute } = useFetchJson({
  url: "/api/v1/stories",
  method: "GET",
  immediate: true,
});

watch(data, (newData) => {
  if (newData) {
    stories.value = newData;
  }
});

watch(fetchError, (err) => {
  if (err) {
    error.value = err;
  }
});

watch(fetchLoading, (isLoading) => {
  loading.value = isLoading;
});
</script>

<template>
    <div class="dating-simulator">
        <TheHeader :userName="userName" />

        <main class="content">
            <div class="top-controls">
                <button @click="returnToDashboard" class="return-btn">
                    <span class="return-icon">←</span> Return to Date Selection
                </button>
            </div>

            <div v-if="loading" class="loading">
                <div class="spinner"></div>
                <p>Loading your date...</p>
            </div>

            <div v-else-if="error" class="error">
                <p>{{ error }}</p>
                <button @click="loadUserProgress" class="retry-btn">
                    Try Again
                </button>
            </div>

            <ChapterView
                v-else-if="currentChapter"
                :chapter="currentChapter"
                :choices="choices"
                @choice-selected="makeChoice"
            />

            <div class="reset-container">
                <button @click="resetProgress" class="reset-btn">
                    Restart Date
                </button>
            </div>

            <div>
              <h1>Liste des histoires</h1>
              <div v-if="loading">Chargement...</div>
              <div v-else-if="error">{{ error }}</div>
              <ul v-else>
                <li v-for="story in stories" :key="story.id">{{ story.title }}</li>
              </ul>
            </div>
        </main>
    </div>
</template>

<style scoped>
/* Dating theme colors */
:root {
    --primary: #ff6b6b;
    --primary-light: #ff8787;
    --secondary: #845ef7;
    --accent: #ffd43b;
    --bg-light: #fff0f3;
    --text-dark: #343a40;
    --border-color: #ffe3e3;
}

.dating-simulator {
    max-width: 100%;
    margin: 0 auto;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: var(--bg-light);
}

.content {
    padding: 2rem;
    max-width: 800px;
    margin: 0 auto;
    width: 100%;
    flex: 1;
}

</style>