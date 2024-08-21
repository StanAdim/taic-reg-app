<script lang="ts" setup>
import ContentLoading from "~/components/usables/contentLoading.vue";

definePageMeta({
  middleware:'auth'
})
useHead({
  title: 'TAIC - Users'
})
const authStore = useAuthStore()
const initialize = async () => {
  await authStore.retrieveAppUsers()
}
const handleSelected = (selectedIds) => {
  const selectedUser = []
  selectedUser.push(selectedIds)
}
const  goToUser = (pathKey)=> navigateTo(`/crm/users/user/${pathKey}`)
onNuxtReady(()=> {
   initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="REGISTERED SYSTEM USER USERS"/>
    <content-loading />
    <div class=" border border-gray-200 md:rounded-lg p-2 bg-sky-100">
      <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
        <table v-if="authStore.getAppUsers" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-sky-100 font-bold  ">
          <tr>
          <th class="px-4 py-3.5 text-sm  text-center" scope="col">Sn</th>
            <th class="py-3.5 px-4 text-sm text-left rtl:text-right " scope="col">
              <div class="flex items-center gap-x-3">
                <input class="text-blue-500 border-gray-300 rounded  dark:ring-offset-gray-900 " type="checkbox">
                <button class="flex items-center gap-x-2">
                  <span>Username</span>
                  <svg-a-z />
                </button>
              </div>
            </th>

            <th class="px-4 py-3.5 text-sm  text-center" scope="col">Role</th>
            <th class="px-4 py-3.5 text-sm  text-center" scope="col">Email</th>
            <th class="px-4 py-3.5 text-sm  text-center" scope="col">Registered On</th>
            <th class="px-4 py-3.5 text-sm  text-center" scope="col">Email Verification</th>
            <th class="px-4 py-3.5 text-sm  text-center" scope="col">Actions</th>


          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
          <tr v-for="(item ,$index ) in authStore.getAppUsers" :key="item">
            <td class="px-4 py-4 text-sm  whitespace-nowrap text-center">{{ $index + 1 }}</td>
            <td class="px-4 py-4 text-sm font-medium text-gray-700  whitespace-nowrap">
              <div class="inline-flex items-center gap-x-3">
                <input class="text-blue-500 border-gray-300 rounded" @change="handleSelected(item.userKey)" type="checkbox">
                <span>{{ item.userName }}</span>
              </div>
            </td>
            <td class="px-4 py-4 text-sm  whitespace-nowrap">{{ item.role }}</td>
            <td class="px-4 py-4 text-sm  whitespace-nowrap">{{ item.email }}</td>
            <td class="px-4 py-4 text-sm  whitespace-nowrap">{{ item.registrationDate }}</td>
            <td class="px-4 py-4 text-sm  whitespace-nowrap text-center">
              <span v-if="item.isVerified" class="text-green-600"><i class="fa fa-dot-circle fa-xl"></i></span>
              <span v-else class="text-red-600"><i class="fa fa-dot-circle fa-xl"></i></span>
            </td>
            <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
            <div @click="goToUser(item.userKey)"
                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-sky-400 bg-sky-600 ">
              <p class="text-sm font-normal mx-3"><i class="fa-solid fa-circle-info"></i></p>
            </div>
              <div
                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-yellow-400 bg-yellow-600 ">
                <p class="text-sm font-normal mx-3"><i class="fa fa-lock"></i></p>
              </div>
              <div
                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-violet-400 bg-violet-600">
                <p class="text-sm font-normal mx-3"><i class="fa-solid fa-pen"></i></p>
              </div>
              <div
                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-zinc-400 bg-zinc-600">
                <p class="text-sm font-normal mx-3"><i class="fa-solid fa-pen-ruler"></i></p>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <div v-else class="">
        </div>
      </div>
      <div class="flex items-center justify-between mt-6">
        <a class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100    "
           href="#">
          <i class="fa fa-arrow-left"></i>
          <span>
                  previous
              </span>
        </a>

        <div class="items-center hidden md:flex gap-x-3">
          <a class="px-2 py-1 text-sm text-blue-500 rounded-md  bg-blue-100/60" href="#">1</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">2</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">3</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">...</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">12</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">13</a>
          <a class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100" href="#">14</a>
        </div>

        <a class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100    "
           href="#">
              <span>
                  Next
              </span>
          <i class="fa fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>