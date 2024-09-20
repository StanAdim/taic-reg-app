<script setup lang="ts">
import {useEventStore} from "~/stores/useEventStore";

const props = defineProps({
  passedAccountInfo: {
    type: String,
    default: null
  },
  showStatus: {
    type: Boolean,
    default: false
  }
})
const eventStore = useEventStore();
const authStore = useAuthStore()
const user = authStore.getLoggedUser
const documentStore = useDocumentMaterialStore()
const globalData = useGlobalDataStore()

// Form inputs
const formInputs = ref({
  file: null,  // Ensure file is initialized as null or a File object
  name: '',
  conference_id: '',
});
// Handle file change
const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    formInputs.value.file = target.files[0];
    // formInputs.value.file = URL.createObjectURL(target.files[0]);
  }
};

const handleFileUpload = async () => {
  if (!formInputs.value.file) {
    const message = 'Please select a file to upload.';
    globalStore.assignAlertMessage(message, 'warning');
    return;
  }

  // Create FormData
  const formData = new FormData();
  formData.append('document', formInputs.value.file);
  formData.append('name', formInputs.value.name);
  formData.append('conference_id', formInputs.value.conference_id);
  // Log the form data contents for debugging
  // for (let [key, value] of formData.entries()) {
  //   console.log(`${key}:`, value);
  // }
  await documentStore.uploadNewDocument(formData)
};
</script>
<template>
  <div class="fixed z-[40] inset-0 overflow-y-auto rounded-lg mt-32 bg-black bg-opacity-60" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="bg-blue-100 rounded-lg px-2 shadow-xl">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             UPLOAD EVENT DOCUMENTS
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="documentStore.toggleDocumentUploadModalStatus(false)"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <!-- component -->
          <div class="flex  justify-center">
            <div class="bg-white align-middle  shadow-md rounded-lg md:px-10 px-8 py-2 my-1">
              <form @submit.prevent="handleFileUpload">
                <div class="mb-4">
                  <label for="documentName" class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                  <input type="text" id="documentName" v-model="formInputs.name"
                         class="input-form"
                         placeholder="Document Name" required>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2">
                  <label for="region_id" class="block text-sm font-medium text-gray-700">Belong to Event</label>
                  <select v-model="formInputs.conference_id" id="region_id"
                          class="input-form" required>
                    <option value="" disabled>Choose An Event</option>
                    <option v-for="item in eventStore.getEvents" :key="item.id" :value="item.id">{{item.name}}</option>
                  </select>
                </div>
                <div class="mb-4">
                  <label for="documentFile" class="block text-sm font-medium text-gray-700 mb-2">Document File</label>
                  <input type="file" @change="handleFileChange" id="documentFile"
                         class="input-form"
                         required>
                </div>
                <button class="w-fit px-6 rounded-md bg-sky-400 py-2 text-white hover:bg-sky-600">Submit Document</button>
              </form>
            </div>
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
.input-form {
  @apply block mt-2 w-full rounded-md  py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
}
</style>