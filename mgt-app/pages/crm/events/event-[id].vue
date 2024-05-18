<script lang="ts" setup>
const eventStore = useEventStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const eventData = ref(null)
const initialize = async () => {
  await eventStore.fetchSingleEvent(route.params.id)
  eventData.value = eventStore.getSingleEventDetail
}
initialize()
</script>

<template>
  <div class="">
    <AdminThePageTitle title="EVENT DETAILS"/>
    <template v-if="eventData">
      <div class="flex justify-center mt-3">
      <div class="container w-full md:w-3/5 border rounded-md p-1 border-sky-600 ">
        <div class="ml-3 text-gray-900 block">
          <p
              class=" bg-blue-200 mt-0.5 my-0.5 py-1 px-4 rounded-sm pl-4 text-lg text-sky-900 font-bold">
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
          <p class="mx-3 my-1 font-medium">Default:<em
              class="text-fuchsia-950 p-2">{{ globalStore.separateNumber(eventData.defaultFee) }} Tsh</em></p>
          <p class="mx-3 my-1 font-medium">Guest: <em
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
      </div>

    </template>
  </div>
</template>

<style scoped>

</style>