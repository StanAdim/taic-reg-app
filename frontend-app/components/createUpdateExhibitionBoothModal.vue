<script setup>

// Props for the component
const props = defineProps({
  booth: {
    type: Object,
    default: () => ({
      name: '',
      size: '',
      benefit: '',
      amount: 0,
      status: 2,
      conference_id: 0
    })
  },
  isUpdateMode: {
    type: Boolean,
    default: false
  },
  showStatus: {
    type: Boolean,
    default: false
  }
})
const eventStore = useEventStore()
// Reactive form data initialized from props
const formData = reactive({
  id: props.booth.id,
  name: props.booth.name,
  size: props.booth.size,
  benefit: props.booth.benefit,
  amount: props.booth.amount,
  status: props.booth.status,
  conference_id: props.booth.conference_id
})
const boothStore = useBoothStore()
// Handle form submission
const handleSubmit = async () => {
  try {
    if (props.isUpdateMode) {
      // Update mode: send PUT request
      await  boothStore.updateBooth(formData);
    } else {
      // Create mode: send POST request
       await  boothStore.createBooth(formData);
    }
  } catch (error) {
    console.error('Error submitting form:', error)
  }
  await closeModal()
}
const closeModal = async ()=> {
  await  boothStore.retrieveBooths();
  boothStore.toggleCreateUpdateDialogState(false)
}
</script>
<template>
  <div class="fixed z-20  inset-0 overflow-y-auto rounded-lg mt-32 bg-black bg-opacity-60" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="bg-blue-100 rounded-lg px-2 shadow-xl md:w-1/2">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             CREATE YOUR ACCOUNT
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="closeModal()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <!-- component -->
          <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">
              {{ isUpdateMode ? 'Update Booth' : 'Create Booth' }}
            </h2>
            <form @submit.prevent="handleSubmit">
              <!-- Name Input -->
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input
                    v-model="formData.name"
                    type="text"
                    id="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter booth name"
                    required
                />
              </div>

              <!-- Size Input -->
              <div class="mb-4">
                <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                <input
                    v-model="formData.size"
                    type="text"
                    id="size"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter booth size"
                    required
                />
              </div>

              <div class="mb-4">
                <label for="benefit" class="block text-sm font-medium text-gray-700 mb-1">Benefit</label>
                <input
                    v-model="formData.benefit"
                    type="text"
                    id="benefit"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter booth benefit"
                    required
                />
              </div>

              <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                <input
                    v-model="formData.amount"
                    type="number"
                    id="amount"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter booth amount"
                    required
                />
              </div>
              <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select
                    v-model="formData.status"
                    id="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                  <option value="2" disabled>Select status</option>
                  <option value="1">Available</option>
                  <option value="0">Unavailable</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Conference | Event </label>
                <select
                    v-model="formData.conference_id"
                    id="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                  <option value="0" disabled>Select conference</option>
                  <option :value="item.id" v-for="item in eventStore.getEvents " :key="item">{{item.name}}</option>
                </select>
              </div>

              <div class="text-center">
                <button
                    type="submit"
                    class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  {{ isUpdateMode ? 'Update' : 'Create' }}
                </button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>
<style scoped>
.hide {
  display: none;
}
</style>