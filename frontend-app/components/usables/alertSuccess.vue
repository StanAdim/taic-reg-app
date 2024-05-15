<script setup>
defineProps({
  message: String,
  hide:{
    type: Boolean,
    default: true
  }
})

</script>

<template>
  <div class="flex justify-center z-20  inset-0 overflow-y-auto mx-4 my-2" :class="{'hidden': hide}">
    <div
        class="alert-suc text-2xl px-5 py-2 max-w-xs  my-2  text-white rounded-lg shadow  z-10000"
        role="alert"
    >
      <div class="ms-3 text-sm font-normal"> {{message}} </div>
    </div>
  </div>
</template>
<style  scoped>
.alert-suc {
  background-color: rgba(4, 115, 4, 0.87);
}

</style>