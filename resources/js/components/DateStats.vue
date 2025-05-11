<script setup>
const props = defineProps({
    stats: {
        type: Object,
        required: true,
        default: () => ({
            attraction: 65,
            connection: 50,
            confidence: 30,
            chemistry: 45,
        })
    }
});
</script>

<template>
    <div class="date-stats">
        <div class="stat-item">
            <span class="stat-label">Attraction</span>
            <div class="stat-bar">
                <div class="stat-fill" :style="{ width: `${stats.attraction}%` }"></div>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-label">Connection</span>
            <div class="stat-bar">
                <div class="stat-fill" :style="{ width: `${stats.connection}%` }"></div>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-label">Confidence</span>
            <div class="stat-bar">
                <div class="stat-fill" :style="{ width: `${stats.confidence}%` }"></div>
            </div>
        </div>
        <div class="stat-item">
            <span class="stat-label">Chemistry</span>
            <div class="stat-bar">
                <div class="stat-fill" :style="{ width: `${stats.chemistry}%` }"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.date-stats {
  display: flex;
  gap: 1.5rem;
  background: var(--bg-white);
  padding: 1.25rem;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-md);
}

.stat-item {
  flex: 1;
  min-width: 120px;
}

.stat-label {
  display: block;
  font-size: 0.875rem;
  color: var(--text-muted);
  margin-bottom: 0.5rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-bar {
  height: 8px;
  background-color: var(--bg-light);
  border-radius: var(--border-radius-full);
  overflow: hidden;
  position: relative;
}

.stat-fill {
  height: 100%;
  border-radius: var(--border-radius-full);
  transition: width var(--transition-normal);
  position: relative;
}

.stat-fill[data-stat="attraction"] {
  background: linear-gradient(to right, var(--primary-light), var(--primary));
}

.stat-fill[data-stat="connection"] {
  background: linear-gradient(to right, #4facfe, #00f2fe);
}

.stat-fill[data-stat="confidence"] {
  background: linear-gradient(to right, #43e97b, #38f9d7);
}

.stat-fill[data-stat="chemistry"] {
  background: linear-gradient(to right, var(--secondary), #a78bfa);
}

@media (max-width: 768px) {
  .date-stats {
    flex-direction: column;
    gap: 1rem;
  }

  .stat-item {
    min-width: unset;
  }
}
</style>

