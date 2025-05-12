<script setup>
const props = defineProps({
    error: {
        type: [String, Object],
        default: null
    },
    onRetry: {
        type: Function,
        required: false
    },
    onDismiss: {
        type: Function,
        required: false
    }
})

function getErrorMessage(error) {
    if (typeof error === 'string') return error
    if (error?.message) return error.message
    return 'Une erreur inattendue est survenue'
}
</script>

<template>
    <transition name="fade">
        <div v-if="error" 
             class="fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg max-w-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm">{{ getErrorMessage(error) }}</p>
                    <div v-if="onRetry" class="mt-2">
                        <button @click="onRetry" 
                                class="text-sm font-medium underline hover:text-red-800">
                            Réessayer
                        </button>
                    </div>
                </div>
                <button v-if="onDismiss" 
                        @click="onDismiss" 
                        class="ml-auto pl-3">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>