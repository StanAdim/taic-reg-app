<script setup>
useHead({
    title: 'TAIC - Timetable'
})
definePageMeta({
    middleware:'auth'
})
const globalData = useGlobalDataStore()
</script>
<template>
  <div class="">
    <AdminThePageTitle title="SYSTEM REPORTS" />
    <div>
      <p>System Reports</p>
    </div>
  </div>

</template>