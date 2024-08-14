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

const headers = ref(['Sn', 'Participant', "Conference" , 'Fee',"Control Number",'Payment Status', 'Status code','Status Desc','Paid Amount', 'date', 'Actions'])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

const filteredItems = computed(() => {
  if (!searchQuery.value) {
    return items.value
  }
  return items.value.filter(item =>
      Object.values(item).some(value =>
          String(value).toLowerCase().includes(searchQuery.value.toLowerCase())
      )
  )
})

const totalPages = computed(() => {
  return Math.ceil(filteredItems.value.length / itemsPerPage.value)
})

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const goToPage = (page) => {
  currentPage.value = page
}

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1
  }
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1
  }
}

const handleBillReconcile = async () => {
  const formData = reactive({
    reconciliation_date : pickedDate.value
  })
  await billStore.handleBillReconciliation(formData)
}

const handleBilCancel = async (row) => await billStore.handleBillCancellation(row.id)
const handleRemoveSubscription = async (row) => {
  console.log(row?.id)
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
    <div class="overflow-x-auto rounded-lg shadow-lg">
      <table class="max-w-full bg-white rounded-lg overflow-hidden">
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
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
            {{ index + 1 }}
          </td>
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
                @click="previousPage"
                :disabled="currentPage === 1"
                class="px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-500 hover:bg-gray-50"
            >
              Previous
            </button>
          </li>
          <li v-for="page in totalPages" :key="page">
            <button
                @click="goToPage(page)"
                :class="[
                'px-3 py-2 border border-gray-300 rounded-md text-sm font-medium',
                page === currentPage
                  ? 'bg-blue-500 text-white'
                  : 'text-gray-500 hover:bg-gray-50'
              ]"
            >
              {{ page }}
            </button>
          </li>
          <li>
            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
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


