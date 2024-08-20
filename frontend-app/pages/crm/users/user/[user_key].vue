<script setup lang="ts">
definePageMeta({middleware:'auth'})

const userStore = useUserStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const userData = ref(null)

const init = async  ()=> {
  await userStore.retrieveSystemUserDetail(route.params.user_key)
  userData.value = userStore.getSystemUserDetail
}
onNuxtReady(()=> {
   init()
})

</script>

<template>
  <div class="mx-2">
      <AdminThePageTitle title="USER DETAILS"/>
    <!-- Container -->
    <template v-if="userData">
      <div class="max-w-4xl p-6 bg-white shadow-md rounded-lg mt-10">

        <!-- User Profile Header -->
        <div class="flex flex-wrap items-center  space-x-6">
          <img class="w-24 h-24 rounded-full" src="/speakers/placeholder.png" alt="User Avatar">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ userData?.user?.firstName }} {{userData?.user?.lastName}}</h1>
            <p class="text-gray-600">{{ userData?.user?.role }}</p>
          </div>
        </div>

        <!-- User Details -->
        <div class="mt-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">User Information</h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Email</p>
              <p class="text-gray-800">{{ userData?.user?.email }}</p>
            </div>

            <div>
              <p class="text-gray-600 font-semibold">Professional Status</p>
              <p class="text-gray-800">{{ userData?.user?.userInfo?.professionalStatus }}</p>
            </div>
            <div>
              <p class="text-gray-600 font-semibold">Booked Events</p>
              <p class="text-gray-800">{{ userData?.subscriptions }}</p>
            </div>

            <div>
              <p class="text-gray-600 font-semibold">Bill Generated</p>
              <p class="text-gray-800">{{ userData?.bills }}</p>
            </div>
            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Phone</p>
              <p class="text-gray-800">{{  userData?.user?.userInfo?.phoneNumber }}</p>
            </div>

            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Address</p>
              <p class="text-gray-800">{{  userData?.user?.userInfo?.position }}, {{  userData?.user?.userInfo?.nation }}</p>
            </div>

            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Joined Date</p>
              <p class="text-gray-800">{{ userData?.user?.registrationDate}}</p>
            </div>
          </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">About</h2>
          <p class="text-gray-700 leading-relaxed">...</p>
          <p class="text-gray-700 leading-relaxed"></p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
          <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600">Edit Profile</button>
        </div>
      </div>
    </template>
    <div class="" v-else>
      <UsablesContentLoading />
    </div>
    </div>
</template>

<style scoped>

</style>