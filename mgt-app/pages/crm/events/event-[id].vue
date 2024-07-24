<script lang="ts" setup>
definePageMeta({
  middleware:'auth'
})
const eventStore = useEventStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const eventData = ref(null)
const initialize = async () => {
  await eventStore.fetchSingleEvent(route.params.id)
  eventData.value = eventStore.getSingleEventDetail
}
const headers = [
    {key:'userName', name:'Name'},{key:'phoneNumber',
    name:' Phone'},{key:'institution',
    name:'Institution'},{key:'region', name:'Region'},{key:'payment', name:'Status'},]
initialize()
</script>

<template>
  <div class="">
    <AdminThePageTitle title="EVENT DETAILS"/>
    <template v-if="eventData">
      <div class="flex justify-center flex-wrap md:flex-nowrap mt-3">
      <div class="container w-full md:w-3/5 border rounded-md p-1 border-sky-600 mx-1 ">
        <div class="ml-3 text-gray-900 block">
          <p
              class=" bg-sky-300 mt-0.5 my-0.5 py-1 px-4 rounded-sm pl-4 text-lg text-sky-900 font-bold">
            TAIC
            <span class="text-lg font-medium text-sky-900">{{ eventData?.conferenceYear }}</span>
            <span v-if="eventData?.lock" class=" ml-4 text-xl text-emerald-700 text-right"><i
                class="fa fa-check-double mx-2"></i></span>
          </p>
        </div>
        <div class="ml-3 block text-teal-900">
          <p class="my-0.5 py-0 font-medium line-clamp-1	">{{ eventData.theme }}</p>
          <p class="my-1 py-0 font-medium line-clamp-1	">Commence
            <span class="bg-blue-100 py-0.5 px-2 rounded-md  text-blue-600">{{ eventData.startDate }}</span>
          </p>
          <p class="my-1 py-0 font-medium line-clamp-1	">End On
            <span class="bg-orange-100 py-0.5 px-2 rounded-md  text-orange-700">{{ eventData.endDate }}</span>
          </p>

        </div>
        <div class="ml-3 block text-teal-900">
          <p class="my-0.5 py-0 text-lg text-sky-800 font-medium">Fees</p>
          <p class="mx-3 my-1 font-medium">Registered ICT Professional:<em
              class="text-fuchsia-950 p-2">{{ globalStore.separateNumber(eventData.defaultFee) }} Tsh</em></p>
          <p class="mx-3 my-1 font-medium">Non Register | Others: <em
              class="text-fuchsia-950 p-2">{{ globalStore.separateNumber(eventData.guestFee) }} Tsh</em></p>
          <p class="mx-3 my-1 font-medium">Foreigner: <em class="text-fuchsia-950 p-2">{{ eventData.foreignerFee }} $</em></p>
        </div>

        <div class="mx-2 my-4 flex justify-center md:justify-normal">

          <button
              v-if="globalStore.hasPermission('can_subscribe_event')"
              class="mx-1 h-8 w-auto bg-teal-500 hover:bg-teal-700 border-teal-500
                            hover:border-teal-700 text-sm border-4 text-white py-0.5 px-2 rounded"
              type="button">
            Attend  <i class="fa-solid fa-right-to-bracket mx-2"></i>
          </button>
        </div>
      </div>
      <div class="container w-full md:w-3/5 border rounded-md p-1 border-sky-600 mx-1"
           v-if="globalStore.hasPermission('can_modify_event')">
        <div class="ml-3 text-gray-900 block">
          <p
              class=" bg-sky-300 mt-0.5 my-0.5 py-1 px-4 rounded-sm pl-4 text-lg text-sky-900 font-bold">
            Event Summary
          </p>
        </div>
        <div class="ml-3 block text-teal-900">
          <p class="my-0.5 py-0 text-lg text-sky-800 font-medium">Progress</p>
          <p class="mx-3 my-1 font-medium">Attendee: <em class="text-fuchsia-950 p-2">{{ eventData?.attendees }}</em></p>
          <p class="mx-3 my-1 font-medium">Payments: <em class="text-fuchsia-950 p-2">0 Tsh</em></p>
          <p class="mx-3 my-1 font-medium">Speakers: <em class="text-fuchsia-950 p-2">{{ eventData?.speakers}}</em></p>
          <p class="mx-3 my-1 font-medium">Days: <em class="text-fuchsia-950 p-2">{{ eventData?.days.length }}</em></p>
        </div>
      </div>
      </div>
          <div class="mx-1 my-2 " v-if="globalStore.hasPermission('can_modify_event')">
            <h2 class="text-xl text-center font-bold">Event Subscribers</h2>
              <simple-data-table :headers="headers" :data="eventData?.subscribers" />
          </div>
    </template>

  </div>
</template>

<style scoped>

</style>