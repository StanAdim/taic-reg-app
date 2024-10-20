<script lang="ts" setup>
const billStore = useBillStore();
const docStore = useDocumentMaterialStore();

const search = ref('')
const filterTableData = computed(() =>
    billStore.getUserPayments.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const indexMethod = (index: number) => index + 1
const handleControlNumber = (index: number, row) => {
  console.log(index, row)
}
const handleBillDownloading = async (docType, row) => {
  // console.log(row.id)
  await billStore.handleInvoiceDownload(docType,row?.id);
}
const handleCertificateDownload = async ( user : string, conference:string) => {
  const passed_data = {
    conference,
    user
  }
  await docStore.handleCertificateDownload(passed_data);
  // console.log(data)
}
</script>

<template>
  <el-table :data="filterTableData" style="width: 100%" table-layout="auto">
    <el-table-column label="Sn" type="index" :index="indexMethod" />
    <el-table-column label="Bill ID" prop="ReqId" />
    <el-table-column label="Conference Fee" prop="conferenceFee" />
    <el-table-column label="Date Generated " prop="created_at" />
    <el-table-column label="Control Number" prop="controlNumber" />
    <el-table-column label="Bill Code" prop="status_code" />
    <el-table-column label="Bill Desc" prop="bill_status_desc" />
    <el-table-column label="Payment Status" prop="status" />
    <el-table-column label="Paid amount" prop="paid_amt" />
<!--    <el-table-column label="Paid on" prop="trx_dt_tm" />-->
    <el-table-column align="right">
      <template #header>
        <el-input v-model="search" size="default" placeholder="Type to search" />
      </template>
      <template #default="scope">
        <div class="flex flex-wrap flex-row">
          <div class="">
            <el-button class="mx-1 my-0.5"  size="default" type="primary" @click="handleBillDownloading(1,scope.row)">
              <span v-if="scope.row.hasPaid"><i class="fa-solid fa-arrow-down mr-1"></i>Receipt</span>
              <span v-else><i class="fa-solid fa-arrow-down mr-1"></i>Invoice</span>
            </el-button>
          </div>
          <div class="">
            <el-button class="mx-1 my-0.5"  size="default" type="info" v-if="scope.row.hasPaid">
              <span @click="handleCertificateDownload(scope.row?.userKey, scope.row?.conference_id)"><i class="fa-solid fa-arrow-down mr-1"></i>Certificate</span>
            </el-button>
          </div>
          <div class="">
            <el-dropdown size="default" type="primary" v-if="!scope.row.hasPaid" placement="bottom-start">
              <el-button><i class="fa-solid fa-arrow-down mr-1"></i> Remitter </el-button>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item @click="handleBillDownloading(2,scope.row)">CRDB</el-dropdown-item>
                  <el-dropdown-item @click="handleBillDownloading(3,scope.row)">NMB</el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
          </div>
        </div>

      </template>
    </el-table-column>
  </el-table>
</template>


