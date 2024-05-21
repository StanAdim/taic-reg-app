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
            <p class="mx-2 ">Welcome to Dashboard</p>

  </div>
</template>