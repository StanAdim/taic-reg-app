<script lang="ts" setup>
const globalStore = useGlobalDataStore()
</script>

<template>
  <div class="bg-sky-100 pb-1 w-full">
    <div class="flex flex-row flex-wrap pb-2 justify-center md:justify-between lg:justify-between flex-initial mx-4">
      <div class="hidden md:block"><img class="h-12 md:h-24 ml-2" src="/image/logo/nembo.png" alt="nation-emblem"></div>
      <div class="text-center font-bold">
        <p class="text-md md:text-l mt-4">THE UNITED REPUBLIC OF TANZANIA</p>
        <p class="text-sm md:text-2xl">INFORMATION AND COMMUNICATION TECHNOLOGIES COMMISSION</p>
        <p class="text-md md:text-l text-sky-600">Event Management System</p>
      </div>
      <div class="hidden md:block"><img class="w-32 md:h-24 ml-2" src="/image/logo/logo-min.png" alt=""></div>
    </div>
    <!--    <usables-loading v-if="globalStore.getLoadingState" />-->

  </div>
</template>

<style scoped></style>
