<script setup lang="ts">
const globalStore = useGlobalDataStore()
</script>
<template>
  <div class="quicksand">
    <top-labels />
<!--    <usables-alert-success :message="globalStore.getAlertMessage" :hide="globalStore.getSuccessStatus" />-->
<!--    <usables-alert-danger :errors="globalStore.getAlertMessage" :hide="globalStore.getDangerStatus" />-->
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
<style>
.quicksand{
  font-family: "Quicksand", sans-serif;
  font-optical-sizing: auto;
  font-style: normal;
}

.layout-enter-active,
.layout-leave-active {
  transition: all 0.4s;
}
.layout-enter-from,
.layout-leave-to {
  filter: grayscale(1);
}
</style>