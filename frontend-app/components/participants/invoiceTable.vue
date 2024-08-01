<script lang="ts" setup>
const billStore = useBillStore();

const search = ref('')
const filterTableData = computed(() =>
    billStore.getUserPayments.filter(
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
    <el-table-column label="Booking ID" prop="ReqId" />
    <el-table-column label="Conference" prop="name" />
    <el-table-column label="Control Number" prop="controlNumber" />
    <el-table-column label="Date Generated " prop="created_at" />
    <el-table-column label="Status" prop="status" />
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


