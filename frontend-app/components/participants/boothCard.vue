<script setup lang="ts">
const props = defineProps({boothData: {type: Object, default: {id:'',name : '', amount : '', status : '', size :'', benefit :'', conference :'',}}})
const boothRequestStore = useRequestBoothStore()
const setBoothDetails = ref({})
const handleExhibitionBooking = (passedBoothId, passedBoothPrice) => {
  setBoothDetails.value = {
    exhibition_booth_id: passedBoothId,
    price: passedBoothPrice
  }
  boothRequestStore.toggleRequestBoothDialogState(true)
}

</script>

<template>
  <UsablesExhibitionBoothRequestDialog :is-open="boothRequestStore.getRequestBoothDialogState" :booth-details="setBoothDetails" />
  <div class="flex flex-col bg-blue-100/40 border-2 border-blue-800 rounded-3xl m-2">
    <div class="px-6 py-8 sm:p-10 sm:pb-6">
      <div class="grid items-center justify-center w-full grid-cols-1 text-left">
        <div>
          <h2 class="text-lg font-medium tracking-tighter text-gray-600 lg:text-3xl relative">
            {{ props.boothData.name }} <i :class="{'text-green-600': props.boothData.status, 'text-yellow-600': !props.boothData.status}" class="fa fa-dot-circle text-sm  absolute bottom-2 mx-2 "></i>
          </h2>
          <p class="mt-2 text-sm text-gray-500">{{ props.boothData.benefit }}</p>
        </div>
        <div class="mt-6">
          <p><span class="text-2xl font-light tracking-tight text-black">{{ props.boothData.amount }} <small class="text-sm">TSH </small></span>
          </p>
          <p> <span class="text-base font-medium text-gray-500"> /{{ props.boothData.size }} </span></p>
          <p class="mt-2 bg-sky-400/60 text-center rounded-md p-0.5 ">{{ props.boothData.conference }}</p>
        </div>
      </div>
    </div>
    <div class="flex px-6 pb-8 sm:px-8"><span
        @click.prevent="handleExhibitionBooking(props.boothData.id,props.boothData.amount)"
          aria-describedby="tier-company"
          class="flex items-center justify-center w-full px-2 py-1.5 text-center text-white duration-200 bg-sky-700 border-2 border-black rounded-full nline-flex hover:bg-transparent hover:border-black hover:text-black focus:outline-none focus-visible:outline-black text-sm focus-visible:ring-black"
          >Book Exhibition Booth</span>
    </div>
  </div>

</template>

<style scoped>

</style>