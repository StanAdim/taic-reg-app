<script setup lang="ts">
const globalData = useGlobalDataStore()
</script>

<template>
  <span v-if="globalData.getBtnLoaderStatus">
    <span class="loader-01"></span>
  </span>
</template>

<style scoped>

.loader-01 {
  display: inline-block;
  width: 1em;
  height: 1em;
  color: inherit;
  vertical-align: middle;
  pointer-events: none;
  border: .2em dotted currentcolor;
  border-radius: 50%;
  animation: 1s loader-01 linear infinite;
}

@keyframes loader-01 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>