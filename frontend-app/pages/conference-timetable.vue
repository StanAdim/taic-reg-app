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
onNuxtReady(()=> {
  init('Timetable')
})
</script>

<template>
  <div class="pt-5 font-['quicksand']">
    <div class="bg-white">
      <div class="">
        <div class="bg-white">
          <div class="flex justify-center">
            <div class="title">TIMETABLE <span class="mx-2"> <UsablesRobotLoading /></span>
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
                        style="border:none;"
                    >
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
