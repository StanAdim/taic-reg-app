<script setup lang="ts">
const globalStore = useGlobalDataStore()
</script>
<template>
  <div>
    <top-labels />
    <usables-alert-success :message="globalStore.getAlertMessage" :hide="globalStore.getSuccessStatus" />
    <usables-alert-danger :errors="globalStore.getAlertMessage" :hide="globalStore.getDangerStatus" />
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
<style>
.page-enter-active,
.page-leave-active {
  transition: all 0.4s;
}
.page-enter-from,
.page-leave-to {
  opacity: 0;
  filter: blur(1rem);
}
</style>