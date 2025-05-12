<script setup>
import { ref, onMounted } from 'vue';

const emit = defineEmits(['return-to-dashboard']);

function goHome() {
  emit('return-to-dashboard');
}

function logout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

    fetch("/logout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
            Accept: "application/json",
        },
        credentials: 'include'
    })
        .then(() => {
            window.location.href = "/login";
        })
        .catch((error) => {
            console.error("Logout error:", error);
        });
}

const user = ref({
    name: ''
});

onMounted(async () => {
    try {
        const response = await fetch('/api/user', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'include'
        });

        if (!response.ok) {
            throw new Error('Failed to fetch user data');
        }

        const userData = await response.json();
        user.value = userData;
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
});
</script>

<template>
  <header class="bg-white shadow-md">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex-shrink-0 flex items-center">
          <button @click="goHome" 
                  class="text-2xl font-display font-bold text-dating-primary hover:text-dating-primary/90 transition-colors">
            DateSim
          </button>
        </div>

        <div class="flex items-center space-x-4">
          <div class="relative ml-3">
            <div class="flex items-center space-x-3">
              <span class="text-sm font-medium text-gray-700">
                {{ user.name }}
              </span>
              <button @click="logout" 
                      class="px-4 py-2 text-sm font-medium text-white rounded-md bg-dating-primary hover:bg-dating-primary/90 transition-colors">
                Sign Out
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: var(--primary);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.2);
}

.profile-title {
    flex: 2;
    text-align: center;
}

.profile-title h1 {
    margin: 0;
    font-weight: 600;
    font-size: 1.6rem;
    color: white;
}

.welcome-text {
    font-weight: 400;
    opacity: 0.9;
    margin-right: 0.5rem;
}

.actions {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

.logout-btn {
    padding: 0.6rem 1.2rem;
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.logout-btn:hover {
    background-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .header {
        flex-direction: column;
        padding: 1rem;
    }

    .profile-title {
        margin: 0.8rem 0;
    }

    .profile-title h1 {
        font-size: 1.2rem;
    }

    .actions {
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
    }
}
</style>