<script setup>
const props = defineProps({
  showStatus: {
    type: Boolean,
    default: false
  },
  eventDetail: {
    type:String,
    default: null
  }
})
const config = useRuntimeConfig().public
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const subscriptionStore = useSubscriptionStore()
const showConfirmation = ref(false)
const confirmAction = (type)=> {
  if (type === 'open') {
    showConfirmation.value = true
  }else if(type === 'close') {
   showConfirmation.value =false
  closeModal()

  }
}
const closeModal = ()=> {
  globalData.toggleConfirmToAttendModalStatus()
  showConfirmation.value = false
  globalData.hanceLoaderTurn('off')

}
const handleSubscription = async ()=> {
  globalData.hanceLoaderTurn('on')
  const subscription = {eventId : props.eventDetail.id}
  if(authStore.getLoggedUserInfo?.isForeigner){
    subscription.eventFee = props.eventDetail?.foreignerFee
  }
  if(authStore.getLoggedUserInfo?.isProfessional)subscription.eventFee = props.eventDetail?.defaultFee
  if(!authStore.getLoggedUserInfo?.isProfessional)subscription.eventFee = props.eventDetail?.guestFee
 await subscriptionStore.subscribeToAnEvent(subscription)
}
</script>
<template>
  <div id="modal" :class="{'hide': !props.showStatus}" class="fixed z-20 inset-0 overflow-y-auto mt-1 top-48">
    <div class="flex  justify-center items-center ">
      <div class="relative bg-blue-100  rounded-lg shadow-xl py-1 w-2/3 md:w-2/5">
        <div class="border-b-2 border-teal-500 flex justify-between items-center py-1 px-2">
          <span class="text-emerald-800 text-center px-1 py-0.5 bg-zinc-50/5 flex-shrink-0 font-bold">
            CONFIRM TO ATTEND
          </span>
          <span class=" bg-rose-100 text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                @click="closeModal"
          >
            <i class="fa-solid fa-xmark mx-2"></i>
          </span>
        </div>
        <div class=" my-2 mx-2 p-1 ">
          <div class="bg-white rounded-lg shadow-md py-2 my-2 text-center">
            <div class="flex flex-wrap justify-evenly items-center">
              <usables-done-check-anim v-if="globalData.getDoneCheckVisibility" />
              <div class=" mx-3 py-3">
                <h2 class="font-bold text-xl">{{eventDetail?.name}}</h2>
                  <template v-if="!globalData.getDoneCheckVisibility">
                    <p class="my-2">You are about to confirm to attend to this Event</p>

                    <template v-if="authStore.getLoggedUserInfo?.isForeigner" >
                      <p class="">Conference Fee <br class="block md:hidden"> <span class="bg-amber-600 text-white py-1 px-2 rounded-md">
<!--                        {{(globalData.separateNumber(eventDetail?.foreignerFee || 0) * config?.UDSRate )}} Tsh  &asymp;-->
                        {{(globalData.separateNumber(eventDetail?.foreignerFeeInTzs || 0))}} Tsh
                        &asymp;
                        {{globalData.separateNumber(eventDetail?.foreignerFee || 0)}} USD</span>
                      </p>
                    </template>
                    <template v-else>
                      <template v-if="authStore.getLoggedUserInfo?.isProfessional" >
                        <p class="">Conference Fee <br class="block md:hidden"> <span class="bg-amber-600 text-white py-1 px-2 rounded-md">
                        {{globalData.separateNumber(eventDetail?.defaultFee || 0)}} Tsh</span></p>
                      </template>
                      <template v-else>
                        <p class="">Conference Fee <br class="block md:hidden"> <span class="bg-amber-600 text-white py-1 px-2 rounded-md">
                        {{globalData.separateNumber(eventDetail?.guestFee || 0)}} Tsh</span></p>
                      </template>
                    </template>
                  </template>
                  <template v-if="globalData.getDoneCheckVisibility && showConfirmation">
                      <p class="my-2">Oh yes!, Your bill is generated successful! </p>
                      <nuxt-link :to="`payments/`" @click="confirmAction('close')"
                                 class="mx-1 h-8 w-auto bg-sky-500 hover:bg-sky-700 border-sky-500
                              hover:border-sky-700 text-sm border-4 text-white py-0.5 px-2 rounded"
                                 type="button">
                        <i class="fa-solid fa-newspaper mx-2"></i>Proceed with payment
                      </nuxt-link>
                    </template>
              </div>
              <div class="">
                <button @click="confirmAction('open')"  v-if="!showConfirmation"
                      class="mx-1 h-8 w-auto bg-sky-500 hover:bg-sky-700 border-sky-500
                         hover:border-sky-700 text-sm border-4 text-white py-0.5 px-2 rounded"
                        type="button">
                  Confirm booking <i class="fa-solid fa-right-to-bracket mx-2"></i>
                </button>
                <div class="my-1" v-if="showConfirmation && !globalData.getDoneCheckVisibility">
                    <p class="text-sm font-bold text-orange-600">Generate Invoice</p>
                    <usables-hance-loader />
                    <button @click="handleSubscription()"
                        class="bg-sky-600 hover:bg-sky-500 border-sky-500 hover:border-green-300 text-sm border-1 text-white py-0.5 px-2 rounded mx-0.5">
                      <i class="fa fa-check"></i>
                      Yes</button>
                    <button @click="confirmAction('close')"
                        class="bg-gray-600 hover:bg-red-600 border-sky-500 hover:border-red-300 text-sm border-1 text-white hover:text-white py-0.5 px-2 rounded mx-0.5">
                      <i class="fa fa-xmark"></i>
                      No</button>
                </div>

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