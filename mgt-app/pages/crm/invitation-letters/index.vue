<script setup lang="ts">
import {useBillStore} from "~/stores/useBillStore";
import NoData from "~/components/usables/noData.vue";

definePageMeta({
  middleware:'auth'
})

</script>

<template>
  <div class="">
    <AdminThePageTitle title="INVITATION LETTERS" />
      <h2 class="text-sky-700 font-bold">Your Invitation letter Request</h2>
<!--    <no-data v-if="billStore.getUserPayments.length === 0" source="User's bills " />-->
      <div class="my-2">
        <p>..Coming soon</p>
      </div>
  </div>
</template>

<style scoped>

</style>