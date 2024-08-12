<script setup lang="ts">

const props = defineProps({
  subscribers: {
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
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Name</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Email</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Institution</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Payment status</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Send QR</th>
        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-900">Excel</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(user, index) in subscribers" :key="user?.id">
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ index + 1 }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ user?.userName }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ user?.email }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ user?.institution }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">{{ "..." }}</td>
        <td class="px-4 py-2 border-b text-sm text-gray-700">
          <span @click.prevent="handleSendQR(user?.id)" class="bg-sky-600 hover:bg-sky-400 text-white rounded-full cursor-pointer px-4 py-1 ">Send</span>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Additional custom styles can be added here */
</style>
