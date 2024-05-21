<script lang="ts" setup>
useHead({
  title: 'TAIC - HOME'
})
const siteStore = useSiteDataStore()
async function retrieveSiteDate() {
  const {data, error}  = await siteStore.retrieveSiteDate()
  console.log(data.value, error.value)
}
retrieveSiteDate()
</script>

<template>
  <div>
    <LandingFocus />
    <AboutConference />
        <!-- Start Pricing Section -->
        <pricing />
        <!-- End Pricing Section -->
        <!-- Featured -->
        <featured />
        <!-- Featured -->
        <KeySpeaker />

        
  </div>
</template>

<style scoped></style>
