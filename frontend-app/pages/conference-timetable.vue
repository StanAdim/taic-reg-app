<script setup lang="ts">
definePageMeta({
  layout: 'auth'
  // middleware: ["auth-middleware"],
});


const globalData = useGlobalDataStore();
const pdfUrl = ref<string | null>(null);
const sla = ref<Sla | null>(null);

const timetableDocument = async () => {
  globalData.setLoading(true);
  const { data: response, error } = await useApiFetch("/sla/active");
  const slaData = response.value as { data: Sla };

  if (slaData?.data) {
    return slaData.data;
  } else {
    if (error) {
      notificationStore.assignAlertMessage(error.value?.data?.message, "error");
    }
  }
  // globalData.setLoading(false);
};

const getPdfFile = async () => {
  const activeSla: any = await timetableDocument();
  sla.value = activeSla as any;
  globalData.setLoading(true);
  if (activeSla) {
    let headers: any = {
      accept: "application/json",
      Authorization: `Bearer ${auth.getAccessToken}`,
    };
    const extractedPart = activeSla?.path?.split("/v1")[1];
    const { data, error } = await useApiFetch(`/filePreview/?name=`+activeSla?.path, { ...headers });
    const blob = URL.createObjectURL(data.value as Blob);
    pdfUrl.value = blob;
    console.log(error.value)
  }
  globalData.setLoading(false);
};

onNuxtReady(()=> {
  getPdfFile();
})
</script>

<template>
  <div class="pt-5 font-['quicksand']">
    <div class="bg-white">
      <div class="px-5 flex justify-center">
        <div class="bg-white">
          <div class="">
            <div class="title">TIMETABLE</div>
          </div>
          <div class="">
            <div>
              <div class="mt-[10px]">
                <div class="">
                  <iframe
                      v-if="pdfUrl"
                      :src="pdfUrl"
                      width="100%"
                      height="600px"
                  ></iframe>
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
