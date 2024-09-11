<script setup lang="ts">
const props = defineProps({
  requestData: {
    type: Object,
    default: () => ({
      id: '',
      subject: '',
      message: '',
      responses: [],
    })
  },
})

 const formatDate = (date)  =>{
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(date).toLocaleDateString(undefined, options);
}
 const capitalize = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>

<template>
      <div class="">
        <div class="mb-6">
          <h2 class="text-2xl text-blue-600 font-semibold mb-2">{{capitalize(props.requestData?.subject)}}</h2>
          <p class="text-sm text-gray-600">Submitted by: Attendee Name</p>
          <p class="text-sm text-gray-600 mt-1">Status: <span class="text-green-500 px-2">{{props.requestData?.status}}</span>
            <span class="ml-auto text-sm text-gray-500 sm:ml-0 sm:mt-0 mt-2">Posted on: {{ formatDate(props.requestData?.created_at) }}</span>
          </p>
          <p class="font-bold mt-4">Raise Issue Message</p>
          <p class="text-gray-700">{{props.requestData?.message}}</p>

        </div>

        <!-- Responses Section -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Responses {{props.requestData?.responses.length}}</h3>

          <!--   block for each response -->
          <template v-if="props.requestData?.responses.length != 0">
            <div class="mb-6 border-b border-gray-200 pb-4">
              <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2">
                <span class="text-sm text-gray-600">Admin Name</span>
                <span class="ml-auto text-sm text-gray-500 sm:ml-0 sm:mt-0 mt-2">Posted on: Sep 11, 2024</span>
              </div>
              <p class="text-gray-700">We are currently looking into this issue. Please make sure all your browser settings are correct and try again. If the issue persists, we will assist you further.</p>
            </div>
          </template>
        </div>
      </div>
</template>

<style scoped>

</style>