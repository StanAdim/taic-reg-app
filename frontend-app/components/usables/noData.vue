<script setup lang="ts">
const props = defineProps({
  source:{
    type: String,
    default: 'Not assigned'
  }
})
</script>

<template>
  <p class="text-md text-black/40 w-full mx-auto my-2">No {{ source }} data available <i class="fa fa-warning"></i></p>
</template>

<style scoped>

</style>