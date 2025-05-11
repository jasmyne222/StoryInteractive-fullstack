<script setup>
import { ref, onMounted } from "vue";
import TheHeader from '@/components/TheHeader.vue'
import Home from '@/pages/Home.vue'
import ChapterView from '@/pages/ChapterView.vue'

// State
const user = ref({ name: "Guest" });
const isLoading = ref(true);
const currentView = ref("dashboard");
const chapterId = ref(null);
const dateScenarios = ref([]);

// Load initial data
onMounted(async () => {
    try {
        // Load user data
        const userResponse = await fetch("/api/user");
        if (userResponse.ok) {
            user.value = await userResponse.json();
        }

        // Load stories from API
        const storiesResponse = await fetch("/api/stories");
        if (storiesResponse.ok) {
            const stories = await storiesResponse.json();
            dateScenarios.value = stories.map(story => ({
                id: story.id,
                title: story.title,
                description: story.summary,
                available: true, // You can add a field in your database for this
                imageUrl: `/images/date-${story.id}.jpg` // You'll need to handle images
            }));
        }
    } catch (error) {
        console.error("Error loading data:", error);
    } finally {
        isLoading.value = false;
    }
});

function startDate(storyId) {
    if (storyId) {
        currentView.value = "date-simulator";
        chapterId.value = storyId;
    }
}

function returnToDashboard() {
    currentView.value = "dashboard";
    chapterId.value = null;
}
</script>

<template>
    <div class="dating-app">
        <!-- Header -->
        <TheHeader :user="user" :isLoading="isLoading" />

        <!-- Dashboard view -->
        <div v-if="currentView === 'dashboard'" class="scenarios-container">
            <h2>Choose Your Dating Scenario</h2>

            <div class="scenarios-grid">
                <div
                    v-for="scenario in dateScenarios"
                    :key="scenario.id"
                    class="scenario-card"
                    :class="{ disabled: !scenario.available }"
                >
                    <div class="scenario-image">
                        <img :src="scenario.imageUrl" :alt="scenario.title">
                    </div>
                    <div class="scenario-info">
                        <h3>{{ scenario.title }}</h3>
                        <p>{{ scenario.description }}</p>
                        <button
                            @click="startDate(scenario.id)"
                            class="start-btn"
                            :disabled="!scenario.available"
                        >
                            {{ scenario.available ? "Start Date" : "Coming Soon" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Date Simulator view -->
        <ChapterView 
            v-else-if="currentView === 'date-simulator'"
            :chapterId="chapterId"
            @return-to-dashboard="returnToDashboard"
        />
    </div>
</template>

<style>
/* Add your existing styles here, but with dating-themed colors */
:root {
    --primary: #ff6b6b;
    --primary-light: #ff8787;
    --secondary: #845ef7;
    --accent: #ffd43b;
    --success: #51cf66;
    --warning: #fcc419;
    --danger: #ff6b6b;
    --bg-light: #fff0f3;
    --text-dark: #343a40;
    --border-color: #ffe3e3;
}

/* Rest of your styles with the same structure but updated classes */
.dating-app {
    min-height: 100vh;
    background-color: var(--bg-light);
}

.scenarios-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.scenarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.scenario-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.1);
    transition: transform 0.3s ease;
}

.scenario-card:hover {
    transform: translateY(-5px);
}

/* Add more of your custom styles here */
</style>