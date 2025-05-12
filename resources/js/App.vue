<script setup>
import { ref, onMounted } from "vue";
import { useFetchJson } from '@/composables/useFetchJson';
import TheHeader from '@/components/TheHeader.vue'
import Home from '@/pages/Home.vue'
import ChapterView from '@/pages/ChapterView.vue'

// State
const user = ref({ name: "Guest" });
const isLoading = ref(true);
const currentView = ref("dashboard");
const chapterId = ref(null);
const dateScenarios = ref([]);
const error = ref(null);

// Load initial data
onMounted(async () => {
    try {
        isLoading.value = true
        console.log('Fetching stories...')
        
        const { fetchJson } = useFetchJson();
        const stories = await fetchJson('/api/v1/stories');
        
        console.log('Stories data:', stories)  // Modification ici : utiliser stories au lieu de result
        
        if (stories) {  // Modification ici : vérifier stories directement
            dateScenarios.value = stories.map(story => ({
                id: story.id,
                title: story.title,
                description: story.summary,
                available: story.available
            }))
        } else {
            throw new Error('Invalid data format')
        }
    } catch (err) {
        error.value = 'Erreur lors du chargement des données. Veuillez réessayer.';
        console.error('Error loading stories:', err)
    } finally {
        isLoading.value = false
    }
});

function startDate(storyId) {
    console.log('Starting date with ID:', storyId) 
    if (storyId) {
        currentView.value = "date-simulator"
        chapterId.value = parseInt(storyId, 10)
    }
}

function returnToDashboard() {
    currentView.value = "dashboard";
    chapterId.value = null;
}

// Fonction pour réessayer une opération
function retryOperation() {
  error.value = null
  // Relancer la dernière action si nécessaire
}

// Ajoutez une fonction pour vérifier si une histoire est disponible
function isStoryAvailable(story) {
  return story && story.id;
}
</script>

<template>
  <div class="min-h-screen bg-gradient-to-b from-pink-50 to-white">
    <!-- Notification d'erreur -->
    <transition name="fade">
      <div v-if="error" 
           class="fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm">{{ error }}</p>
            <button @click="retryOperation" 
                    class="mt-2 text-sm font-medium underline hover:text-red-800">
              Réessayer
            </button>
          </div>
          <button @click="error = null" class="ml-auto">
            <span class="sr-only">Fermer</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>
      </div>
    </transition>
    
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
                <!-- Histoire disponible -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300">
                    <div class="h-48 bg-pink-100 relative flex items-center justify-center">
                        <span class="text-6xl">❤️</span>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-xl font-semibold text-gray-800">
                            Premier Rendez-vous
                        </h3>
                        <p class="text-gray-600">
                            Un premier rendez-vous qui pourrait mener à quelque chose de spécial... ou pas ! À toi de faire les bons choix.
                        </p>
                        <button @click="startDate(1)"
                                class="w-full py-3 px-6 rounded-lg bg-dating-primary text-white hover:bg-dating-primary/90 transition-colors duration-200">
                            Start Date
                        </button>
                    </div>
                </div>

                <!-- Histoires à venir -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 opacity-75">
                    <div class="h-48 bg-pink-100 relative flex items-center justify-center">
                        <span class="text-6xl">❤️</span>
                        <div class="absolute inset-0 bg-gray-900/50 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Bientôt disponible</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-xl font-semibold text-gray-800">
                            Rendez-vous à l'aveugle
                        </h3>
                        <p class="text-gray-600">
                            Un ami commun vous a arrangé un rendez-vous surprise. À venir prochainement !
                        </p>
                        <button disabled
                                class="w-full py-3 px-6 rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed">
                            Coming Soon
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 opacity-75">
                    <div class="h-48 bg-pink-100 relative flex items-center justify-center">
                        <span class="text-6xl">❤️</span>
                        <div class="absolute inset-0 bg-gray-900/50 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Bientôt disponible</span>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <h3 class="text-xl font-semibold text-gray-800">
                            Deuxième Chance
                        </h3>
                        <p class="text-gray-600">
                            Retrouvailles inattendues avec votre premier amour. À venir prochainement !
                        </p>
                        <button disabled
                                class="w-full py-3 px-6 rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed">
                            Coming Soon
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ChapterView 
            v-if="currentView === 'date-simulator'"
            :storyId="chapterId"
            @return-to-dashboard="returnToDashboard"
        />
    </main>
  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

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