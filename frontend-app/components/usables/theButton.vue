<script setup>
const props = defineProps({
    name: String,
    iconClass: String,
    isNormal: Boolean,
    isDanger: Boolean 
})
</script>
<template>
    <button 
    :class="{'bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700': isNormal, 'bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700': isDanger}"
    class="mx-1 flex-shrink-0  
     text-sm border-4 text-white py-0.5 px-1 rounded"
    type="button">
    {{props.name}} <i class="mx-2" :class="props.iconClass"></i>
    </button>
</template>