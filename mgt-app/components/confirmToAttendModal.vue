<script setup>
const props = defineProps({
  showStatus: {
    type: Boolean,
    default: false
  },
  eventDetail: {
    type:Object,
  }
})
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const subscriptionStore = useSubscriptionStore()

</script>
<template>
  <div id="modal" :class="{'hide': !props.showStatus}" class="fixed z-20 inset-0 overflow-y-auto mt-1 top-48">
    <div class="flex  justify-center items-center ">
      <div class="relative bg-blue-100  rounded-lg shadow-xl py-1 w-2/3 md:w-2/5">
        <div class="border-b-2 border-teal-500 flex justify-between items-center py-1 px-2">
          <span class="text-emerald-800 px-1 py-0.5 bg-zinc-50/5 flex-shrink-0 font-bold text-center">
            CONFIRM TO ATTEND
          </span>
          <span class=" bg-rose-100 text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                @click="globalData.toggleConfirmToAttendModalStatus()"
          >
            <i class="fa-solid fa-xmark mx-2"></i>
          </span>
        </div>
        <div class=" my-2 mx-2 p-1 ">
          <div class="bg-white rounded-lg shadow-md py-2 my-2 text-center">
            <div class="flex flex-wrap justify-evenly items-center">
              <div class=" mx-3 py-3">
                <h2 class="font-bold">TAIC {{eventDetail?.conferenceYear}}</h2>
                  <p class="my-2">You are about to confirm to attend to this Event</p>
                  <template v-if="authStore.getLoggedUserInfo?.professionalStatus === 1" >
                      <p class="">Conference Fee <span class="bg-amber-600 text-white py-1 px-2 rounded-md">{{globalData.separateNumber(eventDetail?.defaultFee || 0)}}</span></p>
                  </template>
                <template v-if="authStore.getLoggedUserInfo?.professionalStatus === 0" >
                      <p class="">Conference Fee <span class="bg-amber-600 text-white py-1 px-2 rounded-md">{{globalData.separateNumber(eventDetail?.guestFee || 0)}}</span></p>
                  </template>
              </div>
              <div class="">
                <button @click="subscriptionStore.subscribeToAnEvent(eventDetail?.id)"
                      class="mx-1 h-8 w-auto bg-sky-500 hover:bg-sky-700 border-sky-500
                         hover:border-sky-700 text-sm border-4 text-white py-0.5 px-2 rounded"
                        type="button">
                  Generate Control Number <i class="fa-solid fa-right-to-bracket mx-2"></i>
                </button>

              </div>
            </div>
          </div>
          <p></p>
          <p></p>
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