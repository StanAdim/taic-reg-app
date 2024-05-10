<script setup>
const props = defineProps({
  passedSchedule: {
    type:String,
    default: null
  },
  showStatus:{
    type: Boolean,
    default:false
  }
})
const globalData = useGlobalDataStore()
const closeModal = ()=> {
  globalData.toggleRegistrationForm()
}
</script>
<template>
  <div class="fixed z-20 inset-0 overflow-y-auto mt-1" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center">
      <div class="relative bg-blue-100 w-4/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500">
          <div for="Theme" class=" bg-blue-50 py-2 block text-xl font-bold text-blue-600 text-center"> CREATE ACCOUNT</div>
          <div class="shadow-lg rounded-lg overflow-hidden my-2">
          </div>
          <div @click="closeModal" class="text-right my-2 mx-2">
            <i class="fa-solid fa-xmark bg-red-100 text-red-600 p-2 rounded-sm"></i>
          </div>
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