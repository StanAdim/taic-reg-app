<script setup lang="ts">
const props = defineProps({
  title: {
    type: String,
    default: ''
  },
  subTitle: {
    type: String,
    default: ''
  }

})
</script>

<template>
  <div class="section-header">
    <h2>{{ props.title.toUpperCase() }}</h2>
    <p class="text-center">{{ props.subTitle }}</p>
  </div>
</template>

<style scoped>

</style>