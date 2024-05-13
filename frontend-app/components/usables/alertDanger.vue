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
  <div class="mx-4 floating" v-for="item in errors" :key="item" :class="{'hidden': hide}">
    <div
        id="toast-success"
        class="flex justify-center alert-dan text-2xl px-5 py-2  items-center max-w-xs  my-2  text-white rounded-lg shadow  z-10000"
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
.floating {
  position:relative;
  top:0;
  z-index: 200;
}
</style>