<script lang="ts" setup>
const props = defineProps({
  requests: {
    type: Array
  }
})
const globalData = useGlobalDataStore()
const search = ref('')
const filterTableData = computed(() =>
    props.requests.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const handleControlNumber = (index: number, row) => {
  console.log(index, row)
}
const handleBillDownloading = (index: number, row) => {
  console.log(index, row)
}
</script>

<template>
  <el-table :data="filterTableData" style="width: 100%">
    <el-table-column label="Booth" prop="booth" />
    <el-table-column label="Company Requesting" prop="companyName" />
    <el-table-column label="Number of Booth" prop="number" />
    <el-table-column label="Fee for Booth" prop="amount" />
    <el-table-column label="User email" prop="user" />
    <el-table-column align="right">
      <template #header>
        <el-input v-model="search" size="default" placeholder="Type to search" />
      </template>
      <template #default="scope">
        <!--        <el-button class="mx-1 my-0.5" type="info" size="small" @click="handleControlNumber(scope.$index, scope.row)">-->
        <!--          <i class="fa-solid fa-rotate mr-0.5"></i>Control Number</el-button>-->
        <!--        <el-button class="mx-1 my-0.5"  size="small" type="primary" @click="handleBillDownloading(scope.$index, scope.row)">-->
        <!--          <i class="fa-solid fa-arrow-down mr-1"></i>Download Bill</el-button>-->
      </template>
    </el-table-column>
  </el-table>
</template>


