<script setup>
import NoData from "~/components/usables/noData.vue";

definePageMeta({
  middleware: 'auth'
})
useHead({
  title: 'Dashboard'
})
const globalStore = useGlobalDataStore()

const subscriptionStore = useSubscriptionStore()
const init = async ()=>{
  await  subscriptionStore.retrieveSubscribedEvents()
}
const cardsInfo = reactive([
  {title: 'Upcoming Events', icon: '---', number: 1},
  {title: 'Total Booked Events', icon: '---', number: 1},
  {title: 'Bill generated', icon: '---', number: 1},
])
onNuxtReady(() => {
  init()
});
</script>
<template>
  <div class="">
    <AdminThePageTitle title="MY BOOKING" />
    <!-- component -->
    <div class="flex border border-sky-100 p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="w-full px-4 py-2">
          <h2  class="text-sky-700 font-bold text-lg my-1">Events booked</h2>
          <div class="flex justify-center my-2">
          </div>
          <div class=" my-2">
            <template v-if="subscriptionStore.getSubscribedEvents.length !== 0">
              <participants-booked-events :conferences="subscriptionStore.getSubscribedEvents" />
            </template>
            <usables-no-data  v-else source="booked events" />
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<style scoped>

</style>