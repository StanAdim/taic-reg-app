<script lang="ts" setup>
  const props = defineProps({
    boothDetails : {
      type:Object,
      default:{exhibition_booth_id : '', price: 0,}
    },
    isOpen: {
      type:Boolean, default:false
    },
  requestData: {
  type: Object,
    default: {  number : 1, id : '', companyEmail : '', companyName :'', message :'',}
  }
  })
  const  boothRequestStore = useRequestBoothStore()
  const  globalStore = useGlobalDataStore()
  const formData = ref({
    // id: props.requestData.id,
    number: props.requestData.number,
    companyEmail: props.requestData.companyEmail,
    companyName: props.requestData.companyName,
    message: props.requestData.message,
  })
  const handleSubmit = async () => {
    formData.value.boothId = props.boothDetails.exhibition_booth_id
    // console.log(formData.value)
    await  boothRequestStore.createBoothReq(formData.value)
  }
  const openDialog = computed(()=> props.isOpen)
</script>

<template>
  <el-dialog
      v-model="openDialog"
      :title="`Price: ${globalStore.separateNumber( props.boothDetails.price * formData.number || 0)}`"
      width="500">
    <form @submit.prevent="handleSubmit">
      <!-- Name Input -->
      <div class="mb-4">
        <label for="numberOfBooths" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
        <input
            v-model="formData.number"
            type="number"
            id="numberOfBooths"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="How many booth"
            required
        />
      </div>

      <!-- Size Input -->
      <div class="mb-4">
        <label for="companyEmail" class="block text-sm font-medium text-gray-700 mb-1">companyEmail</label>
        <input
            v-model="formData.companyEmail"
            type="email"
            id="companyEmail"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Enter Company email "
            required
        />
      </div>

      <div class="mb-4">
        <label for="companyName" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
        <input
            v-model="formData.companyName"
            type="text"
            id="companyName"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Enter company name"
            required
        />
      </div>

      <div class="mb-4">
        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
        <textarea
            v-model="formData.message"
            type="number"
            id="message"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Additional Details"
            required
        />
      </div>

      <div class="text-center">
        <button
            type="submit"
            class="w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          {{ isUpdateMode ? 'Update' : 'Submit' }}
        </button>
      </div>
    </form>
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="boothRequestStore.toggleRequestBoothDialogState(false)">Cancel</el-button>
      </div>
    </template>
  </el-dialog>
</template>


