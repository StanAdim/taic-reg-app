<script setup lang="ts">
import type {DocumentMaterial} from "~/types/interfaces";
import DocumentUploadModal from "~/components/DocumentUploadModal.vue";
import {useEventStore} from "~/stores/useEventStore";
definePageMeta({
  middleware:'auth'
})
const eventStore = useEventStore();
const authStore = useAuthStore();
const globalStore = useGlobalDataStore()
const documentStore = useDocumentMaterialStore()
const  config = useRuntimeConfig()

const search = ref('')
const tableData: DocumentMaterial[] = ref( [
  {
    name: 'Information Booklet',
    event: 'Tanzania annual ICT Conference',
    path: config.public.apiBaseUlr+"/documents/taic_concept_note.pdf"
  },
  ...documentStore.getAllDocs
])
const filterTableData = computed(() =>
    documentStore.getAllDocs?.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)

const deleteFile = async (docID: string) => {
  // console.log(row)
  await  documentStore.deleteDoc(docID)
}
const changeDocStatus = async (docID: string) => {
  // console.log(row)
  await  documentStore.updateDocStatus(docID)
}
const openUploadModal = () => {
  documentStore.toggleDocumentUploadModalStatus(true)}
// Initialize data on component load
const init = async () => {
  await eventStore.retrieveEvents();
  await documentStore.retrieveAllDocuments();
};

//handle file preview
const blobDataFile = ref(null)
const blobDataName = ref('')
const previewFile = async (file_data) => {
  documentStore.togglePreviewModalStatus(true)
  globalStore.toggleContentLoaderState('on');
  blobDataName.value = file_data.name
  let headers: any = {
    accept: "application/json",
    // Authorization: `Bearer ${authStore.getAccessToken}`,
  };
  const { data, error } = await useApiFetch(`/api/preview-document?name=`+file_data.path, { ...headers });
  const blob = URL.createObjectURL(data.value as Blob);
  blobDataFile.value = blob;
  globalStore.toggleContentLoaderState('off');
  if(error.value){
    console.log(error.value)
  }
};

onNuxtReady(() => {
  init();
});
</script>

<template>
  <div class="">
    <ParticipantsDocPreviewerModal :mode="documentStore.getPreviewModalStatus" :title="blobDataName" :blob-data-file="blobDataFile" />
    <AdminThePageTitle title="DOCUMENTS AND TIMETABLES" />
    <div class="flex justify-between">
      <div class="sub-heading">
          <h2 class="text-sky-700 font-bold">Recent Event Documents</h2>
      </div>
      <div class="button">
        <UsablesTheButton
            @click="openUploadModal('create', '')"
            v-if="globalStore.hasPermission('can_create_event')"
            :is-normal="true" name="Upload new Document" iconClass="fa-solid fa-plus" />
      </div>

    </div>
    <DocumentUploadModal :show-status="documentStore.getDocumentUploadDialogStatus" />

    <!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->
      <div class="my-2">
        <div class="flex justify-center ">
          <el-table :data="filterTableData" style="width: 100%">
            <el-table-column label="Document Name" prop="name" />
            <el-table-column label="Event" prop="event" />
            <el-table-column v-if="authStore.getUserRole === 'admin'"  label="status" prop="status" />
            <el-table-column label="Action" align="right">
              <template #header>
                <el-input v-model="search" size="default" placeholder="Type to search" />
              </template>
              <template #default="scope">
                <el-button
                    size="small"
                    type="primary"
                    @click="previewFile(scope.row)"
                >
                  Preview File
                </el-button>
                <el-button
                    v-if="authStore.getUserRole === 'admin'"
                    size="small"
                    type="danger"
                    @click="deleteFile(scope.row?.id)"
                >
                  Delete
                </el-button>
                <el-button
                    v-if="authStore.getUserRole === 'admin'"
                    size="small"
                    type="success"
                    @click="changeDocStatus(scope.row?.id)"
                >
                  <span v-if="scope.row?.status != 'active'">Activate<i class="fa-solid fa-eye mx-2"></i></span>
                  <span v-else>Disable<i class="fa-solid fa-eye-slash mx-2"></i></span>
                </el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </div>
  </div>
</template>

<style scoped>

</style>