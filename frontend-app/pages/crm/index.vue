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
const cardsInfo = ref([])
const statisticsAdmin = ref([])
const init = async ()=>{
  await globalStore.analyticData()
  await  subscriptionStore.retrieveSubscribedEvents()
   cardsInfo.value= [
    {title: 'Upcoming Events', icon: '---', number: globalStore.getOthersStatisticalData?.activeConferences, link_to: '/crm/events'},
    {title: 'Total Booked Events', icon: '---', number: globalStore.getOthersStatisticalData?.bookedEvents, link_to: '/crm/events/my-booking'},
    {title: 'Bill generated', icon: '---', number: globalStore.getOthersStatisticalData?.invoices, link_to: '/crm/payments'},
  ]
  statisticsAdmin.value= [
    {title: 'Registered Events', icon: '---', number: globalStore.getAdminStatisticalData?.conferences, link_to: '/crm/events'},
    {title: 'Registered Users', icon: '---', number: globalStore.getAdminStatisticalData?.users, link_to: '/crm/users'},
    {title: 'Registered Exhibition Booths', icon: '---', number: globalStore.getAdminStatisticalData?.booths, link_to: '/crm/exhibition-booking'},
    {title: 'Submitted Booth Requests', icon: '---', number: globalStore.getAdminStatisticalData?.boothRequest, link_to: '/crm/exhibition-booking'},
    {title: 'Generated Invoices', icon: '---', number: globalStore.getAdminStatisticalData?.all_invoices, link_to: '/crm/payments/generated-bills'},
    {title: 'Settled Bills', icon: '---', number: globalStore.getAdminStatisticalData?.settle_payments, link_to: '/crm/payments/settled-payments'},
  ]
}


onNuxtReady(() => {
  init()
});
</script>
<template>
  <div class="">
    <AdminThePageTitle title="DASHBOARD" />
    <!-- component -->
    <div class="flex border border-sky-100 px-4 pt-2 pb-6 rounded-md">
      <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
          <template v-for="item in cardsInfo" :key="item.title">
            <UsablesMinAnalyticalCard :info="item" />
          </template>
          <template v-if="globalStore.hasPermission('can_modify_event')" v-for="item in statisticsAdmin" :key="item.title">
            <UsablesMinAnalyticalCard :info="item" />
          </template>
        </div>
<!--        <div class="w-full px-4 py-2">-->
<!--          <h2  class="text-sky-700 font-bold text-lg my-1">Recent Event booked</h2>-->
<!--          <div class="flex justify-center my-2">-->
<!--            <UsablesContentLoading />-->
<!--          </div>-->
<!--          <div class=" my-2">-->
<!--            <template v-if="subscriptionStore.getSubscribedEvents.length !== 0">-->
<!--              <div v-for="item in subscriptionStore.getSubscribedEvents" :key="item.event?.conferenceName"-->
<!--                   class="w-full md:w-3/5 bg-white/60 rounded-lg shadow-sm p-5 border-dashed border border-blue-500-->
<!--                          flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 m-1">-->
<!--                <div class="flex flex-col sm:flex-row justify-start items-center gap-4">-->
<!--                  <div class="bg-blue-200 flex p-2 rounded-md"><i class="fa-solid fa-people-group text-xl"></i></div>-->
<!--                  <div class="text-center sm:text-left">-->
<!--                    <h1 class="text-gray-700 text-xl font-bold tracking-wider">{{ item.event?.conferenceName }}</h1>-->
<!--                    <p class="text-gray-500 font-semibold">{{ item.event?.theme }}</p>-->
<!--                    <p class="text-gray-500 font-semibold">{{ item.event?.venue }}</p>-->
<!--                    <p class="text-sm text-emerald-700">Commence: <span class=" text-emerald-900 font-medium">{{ item.event?.startDate }}</span> End: <span class=" text-emerald-900 font-medium">{{ item.event?.endDate }}</span></p>-->
<!--                  </div>-->
<!--                </div>-->
<!--                <div>-->
<!--                  <nuxt-link :to="`events/event-${item.event?.id}`" class="bg-emerald-500 py-2 px-4 text-white font-bold rounded-md hover:bg-emerald-600"><i class="fa-solid fa-location-arrow"></i></nuxt-link>-->
<!--                </div>-->
<!--              </div>-->
<!--            </template>-->
<!--            <usables-no-data  v-else source="booked events" />-->
<!--          </div>-->
<!--        </div>-->
      </div>
    </div>

  </div>
</template>
<style scoped>

</style>