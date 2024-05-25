<script lang="ts" setup>
interface Row {
  [key: string]: any;
}

const props = defineProps<{
  headers: string[];
  data: Row[];
}>();
</script>
<template>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
      <thead class="text-xs text-gray-700 uppercase bg-sky-300 ">
          <tr>
            <th v-for="header in headers" :key="header" scope="col" class="px-6 py-3">
              {{ header }}
            </th>
          </tr>
      </thead>
      <tbody>
      <tr class="bg-white border-b" v-for="(row, index) in data" :key="index">
        <td class="px-6 py-4" v-for="header in headers" :key="header">
          {{ row[header] }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>

</template>
<style scoped>
/* Add any additional custom styles here */
</style>
