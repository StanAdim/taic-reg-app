<script lang="ts" setup>
const globalStore = useGlobalDataStore()
</script>

<template>
  <div class="bg-sky-100 pb-1 w-full">
    <usables-loading v-if="globalStore.getLoadingState" />
    <div class="flex flex-row flex-wrap justify-center md:justify-between lg:justify-between flex-initial mx-4">
      <div class="hidden md:block"><img class="h-12 md:h-24 ml-2" src="/image/logo/nembo.png" alt="nation-emblem"></div>
      <div class="text-center font-bold">
        <p class="text-md md:text-2xl mt-4">UNITED REPUBLIC OF TANZANIA</p>
        <p class="text-sm md:text-l">INFORMATION AND COMMUNICATION TECHNOLOGIES COMMISSION</p>
        <p class="text-md md:text-2xl text-sky-600">ICTC Event Management System</p>
      </div>
      <div class="hidden md:block"><img class="h-12 md:h-24 ml-2" src="/image/logo/logo-min.png" alt=""></div>
    </div>
  </div>
</template>

<style scoped></style>
