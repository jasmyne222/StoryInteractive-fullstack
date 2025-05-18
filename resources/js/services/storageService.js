export const storageService = {
    saveProgress(progressData) {
        try {
            // Sauvegarde la progression par histoire
            const key = `gameProgress_${progressData.story_id}`;
            localStorage.setItem(key, JSON.stringify(progressData));
            return true;
        } catch (err) {
            console.error('Error saving to localStorage:', err);
            return false;
        }
    },

    loadProgress(storyId) {
        try {
            const key = `gameProgress_${storyId}`;
            const progress = localStorage.getItem(key);
            return progress ? JSON.parse(progress) : null;
        } catch (err) {
            console.error('Error loading from localStorage:', err);
            return null;
        }
    },

    clearProgress(storyId) {
        try {
            const key = `gameProgress_${storyId}`;
            localStorage.removeItem(key);
            return true;
        } catch (err) {
            console.error('Error clearing localStorage:', err);
            return false;
        }
    }
};