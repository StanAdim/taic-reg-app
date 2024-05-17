<script setup>
definePageMeta({
  middleware: 'auth'
})
const authStore = useAuthStore()
const globalStore = useGlobalDataStore()
</script>
<template>
  <p v-if="globalStore.hasPermission('can_view_event')">Attendee</p>
  <p v-if="globalStore.hasPermission('can_view_event')">Admin</p>
  <p v-if="globalStore.hasPermission('can_view_event')">Promotor</p>
</template>