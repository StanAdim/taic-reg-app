<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";
import NoData from "~/components/usables/noData.vue";
import type {DocumentMaterial} from "~/types/interfaces";

definePageMeta({
  middleware:'auth'
})

const search = ref('')
const filterTableData = computed(() =>
    tableData.filter(
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
const  config = useRuntimeConfig()
const tableData: DocumentMaterial[] = [
  {
    name: 'Information Booklet',
    event: 'Tanzania annual ICT Conference',
    path: config.public.apiBaseUlr+"/documents/taic_concept_note.pdf"
  },
]
</script>

<template>
  <div class="">
    <AdminThePageTitle title="DOCUMENTS AND TIMETABLES" />
      <h2 class="text-sky-700 font-bold">Recent Event Documents</h2>
<!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->
      <div class="my-2">
        <div class="flex justify-center ">
          <el-table :data="filterTableData" style="width: 100%">
            <el-table-column label="Document Name" prop="name" />
            <el-table-column label="Event" prop="event" />
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