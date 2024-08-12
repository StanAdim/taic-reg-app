<script lang="ts" setup>
const billStore = useBillStore();

const search = ref('')
const filterTableData = computed(() =>
    billStore.getAllBills.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const indexMethod = (index: number) => index + 1
const handleRenew = (index: number, row) => {
  console.log(index, row)
}
const handleBillReconcile = async (index: number, row) => await billStore.handleBillReconciliation(row.id)

const handleBilCancel = async (index: number, row) => await billStore.handleBillCancellation(row.id)

</script>

<template>
  <div class="mx-1">
    <el-table :data="filterTableData" style="width: 100%" table-layout="auto">
      <el-table-column label="Sn" type="index" :index="indexMethod" />
      <el-table-column label="Booking ID" prop="ReqId" />
          <el-table-column label="Participant ID" prop="user" />
      <el-table-column label="Conference" prop="name" />
      <el-table-column label="Conference Fee" prop="conferenceFee" />
      <el-table-column label="Control Number" prop="controlNumber" />
      <el-table-column label="Control Number" prop="**" />
      <el-table-column label="Date Generated " prop="created_at" />
      <el-table-column label="Status" prop="status" />
      <el-table-column label="Status Code" prop="status_code" />
<!--      <el-table-column label="TRX ID" prop="trx_id" />-->
      <el-table-column label="Paid amount" prop="paid_amt" />
      <el-table-column label="Paid on" prop="trx_dt_tm" />
      <el-table-column label="Paid by" prop="pyr_name" />
      <el-table-column label="Operations">
        <template #default="scope">
          <el-button size="small" type="warning" @click="handleRenew(scope.$index, scope.row)">
            Renew
          </el-button>
          <el-button size="small" type="primary" @click="handleBillReconcile(scope.$index, scope.row)">
            Reconcile
          </el-button>
        </template>
      </el-table-column>
      <el-table-column label="Cancel">
        <template #default="scope">
          <el-button size="small" type="danger" @click="handleBilCancel(scope.$index, scope.row)">
            Cancel
          </el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>


