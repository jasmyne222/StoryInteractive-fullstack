import { ref } from 'vue'

/**
 * Composable pour gérer les requêtes API avec état de chargement et erreurs
 * @returns {Object} Méthodes et états pour les requêtes API
 */
export function useFetchJson() {
    const data = ref(null)
    const error = ref(null)
    const loading = ref(false)

    async function fetchJson(url, options = {}) {
        loading.value = true
        error.value = null
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            
            const response = await fetch(url, {
                ...options,
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    ...options.headers
                }
            })

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`)
            }

            const result = await response.json()
            if (!result.success) {
                throw new Error(result.message || 'Une erreur est survenue')
            }

            data.value = result.data
            return result.data
        } catch (e) {
            error.value = e.message
            throw e
        } finally {
            loading.value = false
        }
    }

    return {
        data,
        error,
        loading,
        fetchJson
    }
}