<script setup lang="ts">

const props = defineProps({
  conferences: {
    type: Array,
  },
})

const handleSendQR = (userID) => {
  console.log(userID)
}
</script>

<template>
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg border border-sky-600 my-2">
      <thead>
      <tr>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Sn</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Event Name</th>
<!--        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Theme</th>-->
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Location</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Commence</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">End</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Action</th>
<!--        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Payment status</th>-->
      </tr>
      </thead>
      <tbody>
      <tr v-for="(item, index) in conferences" :key="item?.event?.id">
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ index + 1 }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ item?.event?.conferenceName }}</td>
<!--        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ item?.event?.theme }}</td>-->
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ item?.event?.venue }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">
          <span class=" text-emerald-900 font-medium">{{ item.event?.startDate }}</span>
        </td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">
          <span class=" text-yellow-900 font-medium">{{ item.event?.endDate }}</span>
        </td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">
          <nuxt-link :to="`events/event-${item.event?.id}`" class="bg-emerald-500 py-2 px-4 text-white font-bold rounded-md hover:bg-emerald-600"><i class="fa-solid fa-location-arrow"></i></nuxt-link>

        </td>

      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Additional custom styles can be added here */
</style>
