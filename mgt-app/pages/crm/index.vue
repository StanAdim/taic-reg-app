<script setup>
definePageMeta({
  middleware: 'auth'
})
const authStore = useAuthStore()
const globalStore = useGlobalDataStore()
</script>
<template>
  <div>
    <AdminThePageTitle title="APP DASHBOARD" />
    <!-- component -->

  </div>
</template>