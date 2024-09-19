<script setup lang="ts">
const userStore = useUserStore()

const currentPage = ref <number>(1)
const per_page = ref <number>(12)
const searchQuery = ref('')
const pageSwitchValue = ref(1)
const movePage = async (type:number) => {
  console.log(type)
  if (type === 1){
    currentPage.value = currentPage.value + pageSwitchValue.value
  }else {
    currentPage.value = currentPage.value - pageSwitchValue.value
  }
  await userStore.retrieveProfessionalList(per_page.value,currentPage.value)
}
// change page number
const  isEditing = ref(false)
const toggleEditing =  () => isEditing.value = !isEditing.value
const  updateData = async () => {
  await userStore.retrieveProfessionalList(per_page.value,currentPage.value)
}
const  searchUserData = async () => {
  await userStore.retrieveProfessionalList(per_page.value,currentPage.value, searchQuery.value)
}
const headers = ref(['Sn', 'Name', "RegNo" , 'Phone', 'Email', 'is Verified','DateOfRegistration', 'Actions'])


const init = async () => {
  await userStore.retrieveProfessionalList(per_page.value,currentPage.value, searchQuery.value)
}
onNuxtReady(()=> {
  init()
})
const handleExcelExport = ()=> {
  console.log("Helloe")
}
</script>

<template>
  <div class="mt-2">
    <reg-professional-modal />
    <div class="flex justify-end items-center gap-2 mb-2 mx-4">
      <UsablesTheButton @click.prevent="handleExcelExport" :is-normal="true" name="Upload New" iconClass="fa-regular fa-file-excel" />
      <UsablesTheButton @click.prevent="userStore.toggleRegModalStatus(true)" :is-normal="true" name="Add New" iconClass="fa-solid fa-plus" />
      <div class="">
        <input
            v-model="searchQuery"
            @keyup.enter="searchUserData"
            type="text"
            placeholder="Search..."
            class="search-input"
        />
      </div>
    </div>
    <div class="w-full  py-2">
      <!-- Scrollable Table -->
      <div class="overflow-auto rounded-lg shadow-lg">
        <table class="w-full bg-white rounded-lg overflow-x-auto">
          <thead class="bg-gray-100">
          <tr>
            <th
                v-for="header in headers"
                :key="header"
                class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
            >
              {{ header }}
            </th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          <tr
              v-for="(item, index) in userStore.getProfessionalList"
              :key="item.id"
              class="hover:bg-sky-100">
            <td class="table-data">{{ index + 1 }}</td>
            <td class="table-data">{{ item.name }}</td>
            <td class="table-data">{{ item.RegNo }}</td>
            <td class="table-data">{{ item.phoneNumber }}</td>
            <td class="table-data">{{ item.Email }}</td>
            <td class="table-data">
              <span  class="text-green-600 px-2" v-if="item.isVerified"><i class="fa-regular fa-circle-dot"></i></span>
              <span class="text-red-600 px-2" v-else><i class="fa-regular fa-circle-dot"></i></span>
            </td>
            <td class="table-data">{{ item.DateOfRegistration }}</td>
<!--            <td class="table-data">{{ item.Employer }}</td>-->
            <td class="table-data">
              <el-button class="mx-1 my-0.5"  size="default" type="primary" @click="handleBillDownloading(1,item)">
<!--                <span v-else><i class="fa-solid fa-arrow-down mr-1"></i>Invoice</span>-->
              </el-button>

            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-4">
        <nav aria-label="Page navigation">
          <ul class="inline-flex space-x-2">
            <li>
              <button
                  @click="movePage(2)"
                  class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                Previous
              </button>
            </li>
            <li>
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

            </li>
            <li>
              <button
                  @click="movePage(1)"
                  class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 hover:bg-gray-50"
              >
                Next
              </button>
            </li>
          </ul>
        </nav>
      </div>    </div>
  </div>
</template>

<style scoped>
.table-data {
  @apply px-4 py-0.5 whitespace-nowrap text-sm text-gray-700
}
.btn{
  @apply px-2 py-0.5 mx-0.5 text-sm border border-sky-500 hover:border-sky-700
}
.search-input{
  @apply border border-gray-300 rounded-md px-4 py-1 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500;
}
</style>