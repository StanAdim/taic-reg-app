<script setup lang="ts">
const props = defineProps({
  info: {
    type:Object,
    default:{
      'title': '...',
      'icon': '...',
      'number': '...',
      'link_to': '/',
    }
  }
})
</script>

<template>
  <div class="bg-sky-200/90 p-6 m-2 shadow-2xl rounded-md col-span-1 transform hover:scale-105 transition-transform duration-300">
    <div class="flex justify-between">
      <div>
        <div>
          <p class="font-bold text-4xl">{{ props.info.number || 0 }}</p>
        </div>
        <div class="pt-4">
          <p class="font-semibold">{{ props.info.title }}</p>
        </div>
      </div>
      <div>
        <!--        {{ props.info.icon }}-->
        <nuxt-link :to="props.info.link_to">
          <div class="min-card">
            <div class="text-white text-xl md:text-4xl"><i class="fa-solid fa-location-arrow xl"></i></div>
          </div>
        </nuxt-link>

      </div>
    </div>
  </div>

</template>

<style scoped>
.min-card{
  background: linear-gradient(to right,#5ECBFB, #0CA6EA);
  @apply h-8 w-8 md:h-16 md:w-16 shadow-xl rounded-xl flex justify-center items-center
}
</style>