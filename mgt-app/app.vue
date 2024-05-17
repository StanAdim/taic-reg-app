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
