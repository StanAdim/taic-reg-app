<script setup lang="ts">
import { useEventStore } from '~/stores/useEventStore';
import { useGlobalDataStore } from '~/stores/useGlobalDataStore';
import { ref } from 'vue';

// Define page metadata
definePageMeta({
  middleware: 'auth',
});

// Stores
const eventStore = useEventStore();
const globalStore = useGlobalDataStore();
const docStore = useDocumentMaterialStore();

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

// Handle file upload
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
  await docStore.uploadNewDocument(formData)
};

// Initialize data on component load
const init = async () => {
  await eventStore.retrieveEvents();
  await docStore.retrieveAllDocuments();
};

onNuxtReady(() => {
  init();
});
</script>

<template>
  <div>
    <AdminThePageTitle title="DOCUMENTS UPLOADING" />
    <h2 class="text-sky-700 font-bold">Event Documents Uploading</h2>
    <div class="x-auto bg-white shadow-lg rounded-lg overflow-hidden">
      <template>
        <el-card class="max-w-full">
          <template #header>
            <div class="card-header">
              <span>Upload New Document</span>
            </div>
          </template>
          <div class="mx-2">
            <form @submit.prevent="handleFileUpload">
              <div class="mb-4">
                <label for="documentName" class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                <input type="text" id="documentName" v-model="formInputs.name"
                       class="input-class"
                       placeholder="Document Name" required>
              </div>
              <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="region_id" class="block text-sm font-medium text-gray-700">Belong to Event</label>
                <select v-model="formInputs.conference_id" id="region_id"
                        class="input-class" required>
                  <option value="" disabled>Choose An Event</option>
                  <option v-for="item in eventStore.getEvents" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="documentFile" class="block text-sm font-medium text-gray-700 mb-2">Document File</label>
                <input type="file" @change="handleFileChange" id="documentFile"
                       class="input-class"
                       required>
              </div>
              <button class="w-fit px-6 rounded-md bg-sky-400 py-2 text-white hover:bg-sky-600">Submit Document</button>
            </form>
          </div>
        </el-card>
      </template>
    </div>
  </div>
</template>

<style scoped>
.input-class {
  @apply shadow-sm rounded-md w-96 px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500;
}
</style>
