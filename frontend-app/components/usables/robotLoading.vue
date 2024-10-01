<script setup lang="ts">
const props = defineProps({
  color: {
    type:String,
    default: '#1884ecv'
  }
})
const globalStore = useGlobalDataStore()
</script>

<template>
  <span v-if="globalStore.getContentLoadingState" class="relative -top-1">
    <span class="loader-02 " :class="`text-${props.color}`"></span>
  </span>
</template>

<style scoped>
.loader-02 {
  display: inline-block;
  width: 1em;
  height: 1em;
  //color: #ecf0f3;
  vertical-align: middle;
  pointer-events: none;
  border: .4em solid transparent;
  border-left-color: currentcolor;
  border-right-color: currentcolor;
  border-radius: 50%;
  animation: 1s loader-02 linear infinite;
}
@keyframes loader-02 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>