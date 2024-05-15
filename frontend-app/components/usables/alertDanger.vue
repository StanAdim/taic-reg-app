<script setup>
defineProps({
  errors: Array,
  hide:{
    type: Boolean,
    default: true
  }
})

</script>

<template>
  <div class="flex  justify-end align-top mx-4 " v-for="item in errors" :key="item" :class="{'hidden': hide}">
    <div
        id="toast-success"
        class="z-50 alert-dan text-2xl px-5 py-2  max-w-xs  my-2  text-white rounded-lg shadow "
        role="alert"
    >
      <div class="ms-3 text-sm font-normal" > {{item[0]}} </div>
    </div>
  </div>
</template>
<style  scoped>
.alert-dan {
  background-color: rgba(193, 5, 5, 0.87);
}

</style>