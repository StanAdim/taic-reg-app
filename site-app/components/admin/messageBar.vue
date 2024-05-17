<script setup>
const globalData = useGlobalDataStore()
const props = defineProps({
    message: {
        type:String,
        default: ''
    },
    showStatus:{
        type: Boolean,
        default:false
    }
})
const closeMessageBar = ()=> {
    globalData.toogleShowMessageBar()
}
</script>
<template>
<div class="fixed z-20 inset-0 overflow-y-auto mt-1" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center">
        <div class="relative bg-white w-3/5 rounded-lg shadow-xl">
            <div class="border-b-2 border-teal-500 p-2">
                <div for="Theme" class="block text-sm font-medium text-gray-700 text-center">{{props.message}}</div>
                <div @click="closeMessageBar" class="text-right "><i class="fa-solid fa-xmark bg-red-100 text-red-600 p-1.5 rounded-sm"></i></div>
            </div>
        
        </div>
    </div>
</div>
</template>
<style scoped>
.hide {
    display: none;
}
</style>