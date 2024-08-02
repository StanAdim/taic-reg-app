<script setup lang="ts">
const globalStore = useGlobalDataStore()
</script>

<template>
  <div v-if="globalStore.getContentLoadingState" class="flex justify-center my-2">
    <usables-local-loader />
  </div>
</template>

<style scoped>

</style>