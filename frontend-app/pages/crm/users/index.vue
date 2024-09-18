<script lang="ts" setup>
import ContentLoading from "~/components/usables/contentLoading.vue";

definePageMeta({
  middleware:['auth','admin-role-checker']
})
useHead({
  title: 'System - Users'
})
const authStore = useAuthStore()
const exportStore = useFileExportsStore()

const handleSelected = (selectedIds) => {
  const selectedUser = []
  selectedUser.push(selectedIds)
}
const currentPage = ref <number>(1)
const per_page = ref <number>(12)
const pageSwitchValue = ref(1)
const searchQuery = ref('')
const movePage = async (type:number) => {
  if (type === 1){
    currentPage.value = currentPage.value + pageSwitchValue.value
  }else {
    currentPage.value = currentPage.value - pageSwitchValue.value
  }
  await authStore.retrieveAppUsers(per_page.value,currentPage.value)
}
// change page number
const  isEditing = ref(false)
const toggleEditing =  () => isEditing.value = !isEditing.value
const  updateData = async () => {
  await authStore.retrieveAppUsers(per_page.value,currentPage.value)
}
const  searchUserData = async () => {
  await authStore.retrieveAppUsers(per_page.value,currentPage.value, searchQuery.value)
}
const initialize = async () => {
  await authStore.retrieveAppUsers(per_page.value,currentPage.value)
}

const  goToUser = (pathKey)=> navigateTo(`/crm/users/user/${pathKey}`)
const handleVerification = async  (pathKey) => {
  await authStore.userEmailVerification(pathKey)

}
const handleExcelExport = async () => {
  await exportStore.downloadUsersExcel()
}
onNuxtReady(()=> {
   initialize()
})
</script>

<template>
  <div class="">
    <AdminThePageTitle title="REGISTERED SYSTEM USERS"/>
    <content-loading />
    <div class="flex flex-wrap justify-end">
      <div class="">
        <UsablesTheButton @click.prevent="handleExcelExport" :is-normal="true" name="Excel" iconClass="fa-regular fa-file-excel" />
      </div>
      <div class="mx-4">
        <input
            v-model="searchQuery"
            @keyup.enter="searchUserData"
            type="text"
            placeholder="Search..."
            class="border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
    </div>
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
                <el-popover
                    placement="top-start"
                    :width="100"
                    trigger="hover"
                    content="User Data"
                >
                  <template #reference>
                    <p class="text-sm font-normal mx-3"><i class="fa-solid fa-circle-info"></i></p>
                  </template>
                </el-popover>
              </div>
              <div @click="handleVerification(item.userKey)"
                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-yellow-400 bg-yellow-600 ">
                <el-popover
                    placement="top-start"
                    :width="100"
                    trigger="hover"
                    content="Verify User"
                >
                  <template #reference>
                    <p class="text-sm font-normal mx-3"><i class="fa fa-lock"></i></p>
                  </template>
                </el-popover>
              </div>
<!--              <div-->
<!--                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-violet-400 bg-violet-600">-->
<!--                <p class="text-sm font-normal mx-3"><i class="fa-solid fa-pen"></i></p>-->
<!--              </div>-->
<!--              <div-->
<!--                  class="hover:cursor-pointer inline-flex items-center mx-2 py-1 rounded-lg gap-x-2 text-white hover:bg-zinc-400 bg-zinc-600">-->
<!--                <p  class="text-sm font-normal mx-3"><i class="fa-solid fa-code-compare"></i></p>-->
<!--              </div>-->
            </td>
          </tr>
          </tbody>
        </table>
        <div v-else class="">
        </div>
      </div>
      <div class="flex items-center justify-between mt-6">
        <p class="page-btn"
           @click="movePage(2)">
          <i class="fa fa-arrow-left"></i>
          <span>previous</span>
        </p>
          <div class="flex justify-center flex-row gap-2">
            <div class="">Per page</div>
            <div class="">
              <input
                  v-model="per_page"
                  @blur="toggleEditing"
                  @keyup.enter="updateData"
                  class="text-sky-800 w-16 text-center border-b-2 border-teal-500 rounded-sm px-0.5 outline-none"
              />
            </div>
          </div>
        <p class="page-btn"
           @click="movePage(1)"><span>Next</span><i class="fa fa-arrow-right"></i>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-btn {
 @apply flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100
}
</style>