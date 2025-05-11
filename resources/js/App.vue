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

        // Load stories
        const storiesResponse = await fetch("/api/stories");
        if (storiesResponse.ok) {
            const data = await storiesResponse.json();
            if (data.success && data.data) {
                dateScenarios.value = data.data.map(story => ({
                    id: story.id,
                    title: story.title,
                    description: story.summary,
                    available: true,
                    imageUrl: `/images/dates/default.jpg` // Image par défaut
                }));
            }
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

// Ajoutez une fonction pour vérifier si une histoire est disponible
function isStoryAvailable(story) {
  return story && story.id;
}
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-pink-50 to-white">
        <TheHeader 
            :user="user" 
            :isLoading="isLoading"
            @return-to-dashboard="returnToDashboard"
        />
        
        <main class="container mx-auto px-4 py-8">
            <div v-if="currentView === 'dashboard'" class="space-y-8">
                <h1 class="text-4xl font-bold text-center text-dating-primary">
                    Choose Your Dating Adventure
                </h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="scenario in dateScenarios" 
                         :key="scenario.id"
                         class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="aspect-w-16 aspect-h-9 bg-pink-100">
                            <div class="flex items-center justify-center">
                                <span class="text-4xl">❤️</span>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <h3 class="text-xl font-semibold text-gray-800">
                                {{ scenario.title }}
                            </h3>
                            <p class="text-gray-600">
                                {{ scenario.description }}
                            </p>
                            <button 
                                @click="startDate(scenario.id)"
                                class="w-full bg-dating-primary text-white py-3 px-6 rounded-lg
                                       hover:bg-dating-primary/90 transition-colors duration-200">
                                Start Date
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <ChapterView 
                v-else
                :chapterId="chapterId"
                @return-to-dashboard="returnToDashboard"
            />
        </main>
    </div>
</template>

<style>
Add your existing styles here, but with dating-themed colors
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