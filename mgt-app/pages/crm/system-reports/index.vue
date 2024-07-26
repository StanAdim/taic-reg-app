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
        <AdminThePageTitle title="SYSTEM REPORTS" />
    <div>
          <p>System Reports</p>
    </div>
</template>