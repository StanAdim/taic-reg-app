<script lang="ts" setup>
const billStore = useBillStore();

const search = ref('')
const filterTableData = computed(() =>
    billStore.getAllBills.filter(
        (data) =>
            !search.value ||
            data.user.toLowerCase().includes(search.value.toLowerCase())
    )
)

const now = new Date();
const pastDate = new Date(now);
pastDate.setDate(now.getDate() - 1); // Subtract 10 days from the current date

const pickedDate = ref(`${pastDate.getFullYear()}-${(pastDate.getMonth() + 1).toString().padStart(2, '0')}-${pastDate.getDate().toString().padStart(2, '0')}`);


// Sample data - Replace with your API call or data source
const items = ref([
  { id: 1, column1: 'Data 1', column2: 'Data 2', column3: 'Data 3', column4: 'Data 4' },
  { id: 2, column1: 'Data A', column2: 'Data B', column3: 'Data C', column4: 'Data D' },
  // Add more items as needed
])

const headers = ref(['Sn', 'Participant', "Conference" , 'Fee',"Control Number",'Payment Status', 'Status code','Status Desc','Paid Amount', 'date', 'Prints', 'Actions'])
const searchQuery = ref('')

const currentPage = ref <number>(1)
const per_page = ref <number>(10)
const pageSwitchValue = ref(1)
const movePage = async (type:number) => {
  console.log(type)
  if (type === 1){
    currentPage.value = currentPage.value + pageSwitchValue.value
  }else {
    currentPage.value = currentPage.value - pageSwitchValue.value
  }
  await billStore.retrieveAllBills(per_page.value,currentPage.value)
}
// change page number
const  isEditing = ref(false)
const toggleEditing =  () => isEditing.value = !isEditing.value
const  updateData = async () => {
  await billStore.retrieveAllBills(per_page.value,currentPage.value)
}

const subscriptionStore = useSubscriptionStore()
const handleBillReconcile = async () => {
  const formData = reactive({
    reconciliation_date : pickedDate.value
  })
  await billStore.handleBillReconciliation(formData)
}

const handleBilCancel = async (row) => await billStore.handleBillCancellation(row.id)
const handleRemoveSubscription = async (row) => {
  const formData = ref({
    user_id :row?.user_id,
    event_id :row?.conference_id,
  })
  await subscriptionStore.unsubscribedUserEvent(formData.value)
}
const handleBillDownloading = async (docType, row) => {
  // console.log(row.id)
  await billStore.handleInvoiceDownload(docType,row?.id);
}

</script>
<template>
  <div class="p-2">
    <!-- Search Input -->
    <div class="flex justify-end items-center gap-2 mb-4">
      <input
          v-model="search"
          type="text"
          placeholder="Search..."
          class="border border-gray-300 rounded-md px-4 py-0.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
      <input
          v-model="pickedDate"
          type="date"
          placeholder="Search..."
          class="border border-gray-300 rounded-md px-4 py-0.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

      <div class="mx-1">
        <div @click="handleBillReconcile()" class="btn bg-sky-600 text-white py-0.5 rounded-md cursor-pointer hover:bg-sky-700">Reconciliation</div>
      </div>
    </div>

    <!-- Scrollable Table -->
    <div class="overflow-auto rounded-lg shadow-lg">
      <table class="max-w-full bg-white rounded-lg overflow-x-auto">
        <thead class="bg-gray-100">
        <tr>
          <th
              v-for="header in headers"
              :key="header"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
          >
            {{ header }}
          </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <tr
            v-for="(item, index) in filterTableData"
            :key="item.id"
            class="hover:bg-gray-50">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ index + 1 }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.user }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.conferenceFee }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.controlNumber }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.status }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.status_code }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.bill_status_desc }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.paid_amt || 0  }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ item.created_at }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <el-button class="mx-1 my-0.5"  size="default" type="primary" @click="handleBillDownloading(1,item)">
              <span v-if="item.hasPaid"><i class="fa-solid fa-arrow-down mr-1"></i>Receipt</span>
              <span v-else><i class="fa-solid fa-arrow-down mr-1"></i>Invoice</span>
            </el-button>
            <el-dropdown size="default" type="primary" v-if="!item.hasPaid" placement="bottom-start">
              <el-button><i class="fa-solid fa-arrow-down mr-1"></i> Remitter </el-button>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item @click="handleBillDownloading(2,item)">CRDB</el-dropdown-item>
                  <el-dropdown-item @click="handleBillDownloading(3,item)">NMB</el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            <div class="flex">
              <button @click.prevent="handleBilCancel(item)"
                      class="btn bg-sky-200 text-black/60 hover:text-white hover:bg-sky-400 rounded-md cursor-pointer">Cancel</button>
              <button @click.prevent="handleRemoveSubscription(item)"
                      class="btn bg-gray-200 text-black/60 hover:text-white hover:bg-gray-400 rounded-md cursor-pointer">Unsubscribe</button>
            </div>
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
    </div>
  </div>
</template>
<style scoped>
.btn{
  @apply px-2 py-0.5 mx-0.5 text-sm border border-sky-500 hover:border-sky-700
}
</style>


