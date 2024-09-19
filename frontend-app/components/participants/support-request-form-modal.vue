<script setup lang="ts">
import {useSupportActionStore} from "~/stores/useSupportActionStore";


// Props for the component
const props = defineProps({
  requestData: {
    type: Object,
    default: () => ({
      id: '',
      subject: '',
      message: '',
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
const supportStore = useSupportActionStore()
const globalStore = useGlobalDataStore()
// Reactive form data initialized from props
const formData = reactive({
  id: props.requestData.id,
  subject: props.requestData.subject,
  message: props.requestData.message,

})
// Handle form submission
const handleSubmit = async () => {
  try {
    if (props.isUpdateMode) {
      // Update mode: send PUT request
      await  supportStore.updateRequestStatus(formData);
    } else {
      // Create mode: send POST request
      await  supportStore.createNewRequest(formData);
    }
  } catch (error) {
    console.error('Error submitting form:', error)
  }
  await closeModal()
}
const closeModal = async ()=> {
  await  supportStore.retrieveUserSupportRequests();
  supportStore.toggleModalStatus(false)
}
</script>
<template>
  <div class="fixed z-20  inset-0 overflow-y-auto rounded-lg mt-32 bg-black bg-opacity-60" :class="{'hidden': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="bg-blue-100 rounded-lg px-2 shadow-xl md:p-4">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             ANY QUESTION | INQUIRY FOR ASSISTANCE
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="closeModal()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <!-- component -->
          <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg">

              <form @submit.prevent="handleSubmit()">
                <!-- Subject -->
                <div class="mb-4">
                  <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                  <input type="text" id="subject" v-model="formData.subject" required
                         class="input">
                </div>

                <!-- Message -->
                <div class="mb-4">
                  <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                  <textarea id="message" v-model="formData.message" rows="4" required
                            class="input"></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                  <button type="submit"
                          class="btn">
                    Submit
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
.input {
  @apply mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm
}

.btn {
  @apply px-4 py-2 bg-sky-400 text-white font-semibold rounded-md shadow hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500
}

</style>