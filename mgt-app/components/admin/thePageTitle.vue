<script setup>
const props = defineProps({
    title: String
})
</script>
<template>
    <div class="mb-4 mt-2 text-center">
      <p class="text-2xl text-uppercase">{{ props.title }}</p>
      <hr class="py-0.5 my-1 bg-white">
    </div>
</template>