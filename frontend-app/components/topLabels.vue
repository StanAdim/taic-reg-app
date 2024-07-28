<script lang="ts" setup>
const globalStore = useGlobalDataStore()
</script>

<template>
  <div class="bg-sky-700 py-4 w-full">
      <div class="">
        <div class="w-max flex flex-col-reverse md:grid   md:grid-cols-5 mx-auto gap-1 md:gap-10">
          <div class="md:col-span-1 hidden md:flex justify-center">
            <div class=""><img class=" h-20 md:h-24 ml-2" src="/image/logo/nembo.png" alt="nation-emblem"></div>
          </div>

          <div class="md:col-span-3 px-4 content-stretch text-white">
            <div class="text-center font-bold">
              <div class="text-xs md:text-lg mt-4">THE UNITED REPUBLIC OF TANZANIA</div>
              <div class="text-s md:text-2xl">INFORMATION AND COMMUNICATION <br class="block md:hidden"> TECHNOLOGIES COMMISSION</div>
              <div class="text-xs md:text-lg ">Event Management System</div>
            </div>
          </div>
          <div class="md:col-span-1 flex justify-center">
            <div class=""><img class="h-20 md:h-24 ml-2" src="/image/logo/logo-min.png" alt="nation-emblem"></div>
          </div>

        </div>
      </div>
  </div>

</template>

<style scoped></style>
