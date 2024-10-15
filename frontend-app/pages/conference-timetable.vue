<script setup lang="ts">
definePageMeta({
  layout: 'auth'
});

const docStore =  useDocumentMaterialStore()
const globalData = useGlobalDataStore();

//handle file preview
const blobDataFile = ref(null)
const blobDataName = ref('')
const previewFile = async (file_data: string) => {
  globalData.toggleContentLoaderState('on');
  let headers: any = {
    accept: "application/json",
    // Authorization: `Bearer ${authStore.getAccessToken}`,
  };
  const { data, error } = await useApiFetch(`/api/events-document/${file_data}`, { ...headers });
  const blob = URL.createObjectURL(data.value as Blob);
  blobDataFile.value = blob;
  globalData.toggleContentLoaderState('off');
  if(error.value){
    console.log(error.value)
  }
};

const init = async (fileName)=> {
  await previewFile(fileName);
  }
const handleFileDownload = async (file_data:string) => {
  globalData.toggleContentLoaderState('on');
  let headers: any = {
    accept: "application/json",
    // Authorization: `Bearer ${authStore.getAccessToken}`,
  };
  try {
    // Fetch file data using your API
    const { data, error } = await useApiFetch(`/api/events-document/${file_data}`, { headers });
    globalData.toggleContentLoaderState('off');
    // If there's an error, log it and return
    if (error.value) {
      console.error('Error fetching file:', error.value);
      globalData.assignAlertMessage('Failed to download the file', 'error');
      return;
    }

    // Ensure the data is in Blob format (for PDF)
    const blob = data.value instanceof Blob
        ? data.value
        : new Blob([data.value], { type: 'application/pdf' });

    // Create a download URL for the Blob
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'ems_document_timetable.pdf'); // Set download file name
    document.body.appendChild(link);
    link.click(); // Trigger the download

    // Cleanup
    window.URL.revokeObjectURL(url); // Release the object URL from memory
    document.body.removeChild(link); // Remove the link element

    // Success message
    globalData.assignAlertMessage('Downloaded successfully', 'success');

  } catch (err) {
    console.error('Error during file download:', err);
    globalData.assignAlertMessage('An error occurred while downloading the file', 'error');
  }
};

onNuxtReady(()=> {
  init('Timetable')
})
</script>

<template>
  <div class="pt-5 font-['quicksand']">
    <div class="bg-white">
      <div class="">
        <div class="bg-white">
          <div class="flex md:justify-center justify-start mx-4">
            <div class="title">TIMETABLE <span class="mx-2"> <UsablesRobotLoading /></span>
              <span class="hover:cursor-pointer px-2 py-0.5 bg-emerald-600 text-white rounded-md text-sm"
              @click="handleFileDownload('Timetable')">Download</span>
            </div>
          </div>
          <div class="">
            <div>
              <div class="mt-[10px]">
                <div class="">
                  <div class="w-full h-auto lg:h-[100vh] md:h-[80vh] sm:h-[72vh] relative">
                    <iframe
                        v-if="blobDataFile"
                        :src="blobDataFile"
                        class="w-full h-full"
                        style="border:none;" >
                    </iframe>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss"></style>
