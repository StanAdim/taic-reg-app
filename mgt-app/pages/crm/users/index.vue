<script setup lang="ts">

import auth from "~/middleware/auth";

useHead({
  title:'TAIC - Users'
})
definePageMeta({

})
const authStore = useAuthStore()
const initialize = async () => {
  await authStore.retrieveAppUsers()
  console.log(authStore.getAppUsers)
}
initialize()
</script>

<template>
  <AdminThePageTitle title="APP USERS" />
  <div class=" border border-gray-200 md:rounded-lg p-2 bg-sky-100">
    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" v-if="authStore.getAppUsers">
            <thead class="bg-sky-100 font-bold  ">
            <tr>
              <th scope="col" class="py-3.5 px-4 text-sm text-left rtl:text-right ">
                <div class="flex items-center gap-x-3">
                  <input type="checkbox" class="text-blue-500 border-gray-300 rounded  dark:ring-offset-gray-900 ">
                  <button class="flex items-center gap-x-2">
                    <span>Username</span>

                    <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                      <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                      <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                    </svg>
                  </button>
                </div>
              </th>

              <th scope="col" class="px-4 py-3.5 text-sm  text-center">
                User Type
              </th>

              <th scope="col" class="px-4 py-3.5 text-sm  text-center">
                Email
              </th>
              <th scope="col" class="px-4 py-3.5 text-sm  text-center">
                Registered On
              </th>

                <th scope="col" class="px-4 py-3.5 text-sm  text-center">
                  Actions
              </th>


            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-for="item in authStore.getAppUsers" :key="item">
              <td class="px-4 py-4 text-sm font-medium text-gray-700  whitespace-nowrap">
                <div class="inline-flex items-center gap-x-3">
                  <input type="checkbox" class="text-blue-500 border-gray-300 rounded  dark:ring-offset-gray-900 ">
                  <span>{{item.userName}}</span>
                </div>
              </td>
              <td class="px-4 py-4 text-sm  whitespace-nowrap">{{item.role}}</td>
              <td class="px-4 py-4 text-sm  whitespace-nowrap">{{ item.email }}</td>
              <td class="px-4 py-4 text-sm  whitespace-nowrap">{{ item.registrationDate }}</td>
              <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                <div class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-sky-400 bg-sky-600 ">
                  <p class="text-sm font-normal mx-3"><i class="fa-solid fa-receipt"></i></p>
                </div>
                <div class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-red-400 bg-red-600 ">
                  <p class="text-sm font-normal mx-3"><i class="fa fa-trash"></i></p>
                </div>
                <div class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-violet-400 bg-violet-600">
                  <p class="text-sm font-normal mx-3"><i class="fa-solid fa-pen"></i></p>
                </div>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
    <div class="flex items-center justify-between mt-6">
        <a href="#" class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100    ">
          <i class="fa fa-arrow-left"></i>
          <span>
                  previous
              </span>
        </a>

        <div class="items-center hidden md:flex gap-x-3">
          <a href="#" class="px-2 py-1 text-sm text-blue-500 rounded-md  bg-blue-100/60">1</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">2</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">3</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">...</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">12</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">13</a>
          <a href="#" class="px-2 py-1 text-sm  rounded-md  hover:bg-gray-100">14</a>
        </div>

        <a href="#" class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100    ">
              <span>
                  Next
              </span>
          <i class="fa fa-arrow-right"></i>
        </a>
    </div>
  </div>
</template>

<style scoped>

</style>