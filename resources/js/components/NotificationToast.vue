<script setup>
import { computed, onMounted } from 'vue'

const props = defineProps({
    message: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'info',
        validator: (value) => ['success', 'error', 'info', 'warning'].includes(value)
    },
    timeout: {
        type: Number,
        default: 3000
    }
})

const emit = defineEmits(['close'])

const bgColorClass = computed(() => {
    switch (props.type) {
        case 'success':
            return 'bg-green-100 border-green-500 text-green-700'
        case 'error':
            return 'bg-red-100 border-red-500 text-red-700'
        case 'warning':
            return 'bg-yellow-100 border-yellow-500 text-yellow-700'
        default:
            return 'bg-blue-100 border-blue-500 text-blue-700'
    }
})

onMounted(() => {
    if (props.timeout > 0) {
        setTimeout(() => {
            emit('close')
        }, props.timeout)
    }
})
</script>

<template>
    <div class="fixed top-4 right-4 p-4 rounded-lg border-l-4 shadow-lg max-w-md z-50" :class="bgColorClass">
        <div class="flex items-center">
            <p class="flex-1">{{ message }}</p>
            <button @click="$emit('close')" class="ml-4">
                <span class="sr-only">Fermer</span>
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</template>