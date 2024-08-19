<script setup lang="ts">
import type {DocumentMaterial} from "~/types/interfaces";
import DocumentUploadModal from "~/components/DocumentUploadModal.vue";
import {useEventStore} from "~/stores/useEventStore";
definePageMeta({
  middleware:'auth'
})
const eventStore = useEventStore();
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
    tableData.value.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const handleEdit = (index: number, row: DocumentMaterial) => {
  console.log(index, row)
}
const handleDownload = (index: number, row: DocumentMaterial) => {
  console.log(index, row)
}
const openUploadModal = () => {
  documentStore.toggleDocumentUploadModalStatus(true)}
// Initialize data on component load
const init = async () => {
  await eventStore.retrieveEvents();
  await documentStore.retrieveAllDocuments();


};

onNuxtReady(() => {
  init();
});
</script>

<template>
  <div class="">
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
            <el-table-column label="status" prop="status" />
            <el-table-column align="right">
              <template #header>
                <el-input v-model="search" size="default" placeholder="Type to search" />
              </template>
              <template #default="scope">
                <el-button
                    size="small"
                    type="primary"
                    @click="handleDownload(scope.$index, scope.row)"
                >
                  <a :href="scope.row.path" :download="scope.row.name"
                     target="_blank" class="download-link">
                    Download File
                  </a>
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