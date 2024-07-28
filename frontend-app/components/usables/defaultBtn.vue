<script setup>
const props = defineProps({
    name: {type:String, default: ''},
    iconClass: String,
  colorName: String,
})
</script>
<template>
  <button :class="`mx-1 h-8 w-auto bg-${props.colorName}-500 hover:bg-${props.colorName}-800 border-none text-sm border-4 text-white py-0.5 px-2 rounded`">
          {{ props.name }} <i :class="`${props.iconClass}`"></i>
  </button>
</template>