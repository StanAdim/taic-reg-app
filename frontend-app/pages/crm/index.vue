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
onNuxtReady(() => {
  init()
});
</script>
<template>
  <div class="">
    <AdminThePageTitle title="DASHBOARD" />
    <!-- component -->
    <div class="flex border border-sky-100 p-4 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="w-full px-4 py-2">
          <h2  class="text-sky-700 font-bold text-lg my-1">Event booked</h2>
          <div class="flex justify-center my-2">
            <UsablesContentLoading />
          </div>
          <div class=" my-2">
            <template v-if="subscriptionStore.getSubscribedEvents.length !== 0">
              <div v-for="item in subscriptionStore.getSubscribedEvents" :key="item.event?.conferenceName"
                   class="w-full md:w-3/5 bg-white/60 rounded-lg shadow-sm p-5 border-dashed border border-blue-500
                          flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 m-1">
                <div class="flex flex-col sm:flex-row justify-start items-center gap-4">
                  <div class="bg-blue-200 flex p-2 rounded-md"><i class="fa-solid fa-people-group text-xl"></i></div>
                  <div class="text-center sm:text-left">
                    <h1 class="text-gray-700 text-xl font-bold tracking-wider">{{ item.event?.conferenceName }}</h1>
                    <p class="text-gray-500 font-semibold">{{ item.event?.theme }}</p>
                    <p class="text-gray-500 font-semibold">{{ item.event?.venue }}</p>
                    <p class="text-sm text-emerald-700">Commence: <span class=" text-emerald-900 font-medium">{{ item.event?.startDate }}</span> End: <span class=" text-emerald-900 font-medium">{{ item.event?.endDate }}</span></p>
                  </div>
                </div>
                <div>
                  <nuxt-link :to="`events/event-${item.event?.id}`" class="bg-emerald-500 py-2 px-4 text-white font-bold rounded-md hover:bg-emerald-600"><i class="fa-solid fa-location-arrow"></i></nuxt-link>
                </div>
              </div>
            </template>
            <usables-no-data  v-else source="booked events" />
          </div>
<!--          <participants-booked-events :conferences="subscriptionStore.getSubscribedEvents" />-->

        </div>
      </div>
    </div>

  </div>
</template>
<style scoped>

</style>