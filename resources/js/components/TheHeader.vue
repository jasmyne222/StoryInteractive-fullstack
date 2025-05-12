<script setup>
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
        credentials: 'include',
    })
        .then(() => {
            window.location.href = "/login";
        })
        .catch((error) => {
            console.error("Logout error:", error);
        });
}
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
          <button @click="logout" 
                  class="px-4 py-2 text-sm font-medium text-white rounded-md bg-dating-primary hover:bg-dating-primary/90 transition-colors">
            Déconnexion
          </button>
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
</style>