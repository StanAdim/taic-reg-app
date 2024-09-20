<script setup lang="ts">
const userStore = useUserStore()

const formInputs = ref({ file: ''});

const closeModal = () => {
  userStore.toggleImportModalStatus(false)
};
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
}
const submitForm = async () => {
   await  handleFileUpload()
      const formData = new FormData();
      formData.append('file', formInputs.value.file);
      // Log the form data contents for debugging
      for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
      }
      await userStore.importExcel(formData)
      // Optionally reset form
      Object.keys(form.value).forEach((key) => {
        formInputs.value[key] = '';
      });
      // Close the modal
      closeModal();
      // Optionally, navigate or show success message
};
</script>
<template>
  <div>
    <div
        v-if="userStore.getImportModalStatus"
        class="fixed inset-0 md:flex mt-4 md:items-center md:justify-center bg-black bg-opacity-60 z-10"
    >
      <!-- Modal Content -->
      <div class="bg-white md:w-2/5 w-72 mx-2 p-6 rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-4 border-b">
          <h2 class="text-xl font-bold">Import Professional Data</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-800">
            &times;
          </button>
        </div>
        <!-- Form -->
        <form @submit.prevent="submitForm()" class="mt-2">
          <div class="mb-4">
              <p class="form-paragraph">
                File should be an Excel
              </p>
              <label for="file-input" class="drop-container">
                <span class="drop-title">Choose an  file</span>
                or
                <input @change="handleFileChange" type="file" accept="*" required="" id="file-input">
              </label>
          </div>
          <!-- Modal Footer -->
          <div class="flex justify-end">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.input-form {
  @apply max-w-full p-2 border border-gray-300 rounded mt-1
}

/* From Uiverse.io by Yaya12085 */

.form-title {
  color: #000000;
  font-size: 1.8rem;
  font-weight: 500;
}

.form-paragraph {
  margin-top: 10px;
  font-size: 0.9375rem;
  color: rgb(105, 105, 105);
}

.drop-container {
  background-color: #fff;
  position: relative;
  display: flex;
  gap: 10px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 10px;
  margin-top: 2.1875rem;
  border-radius: 10px;
  border: 2px dashed rgb(171, 202, 255);
  color: #444;
  cursor: pointer;
  transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
  background: rgba(0, 140, 255, 0.164);
  border-color: rgba(17, 17, 17, 0.616);
}

.drop-container:hover .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color .2s ease-in-out;
}

#file-input {
  width: 350px;
  max-width: 100%;
  color: #444;
  padding: 2px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid rgba(8, 8, 8, 0.288);
}

#file-input::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #084cdf;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

#file-input::file-selector-button:hover {
  background: #0d45a5;
}</style>
