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
         <AdminThePageTitle title="app timetable" />
         <div>

         </div>
       </div>
</template>