<script lang="ts" setup>

const props = defineProps({
  booths: {
    type: Array,
  },
})

const search = ref('')
const filterTableData = computed(() =>
    props.booths.filter(
        (data) =>
            !search.value ||
            data.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const handleBoothUpdate = (index: number, row) => {
  console.log(index, row)
}
const handleBoothDelete = (index: number, row) => {
  console.log(index, row)
}
</script>

<template>
  <div class="">
    <el-table :data="filterTableData" style="width: 100%">
      <el-table-column label="Name" prop="name" />
      <el-table-column label="Conference" prop="conference" />
      <!--    <el-table-column label="Control Number" prop="controlNumber" />-->
      <el-table-column label="Price (Tsh)" prop="amount" />
      <el-table-column label="Size" prop="size" />
      =    <el-table-column label="Benefit" prop="benefit" />
      =    <el-table-column label="Status" prop="transStatus" />
      <el-table-column align="right">
        <template #header>
          <el-input v-model="search" size="default" placeholder="Type to search" />
        </template>
        <template #default="scope">
          <el-button class="mx-1 my-0.5" type="info" size="small" @click="handleBoothUpdate(scope.$index, scope.row)">
            <i class="fa fa-pen-alt mr-0.5"></i>Update</el-button>
          <el-button class="mx-1 my-0.5"  size="small" type="danger" @click="handleBoothDelete(scope.$index, scope.row)">
            <i class="fa fa-xmark mr-1"></i>Delete</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>


