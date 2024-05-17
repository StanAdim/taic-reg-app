<script lang="ts" setup>
definePageMeta({
    layout:'auth',
    middleware:'auth'
})
useHead({
    title: 'TAIC - App Dashboard'
})
</script> 

<template>
  <div>
    <AdminThePageTitle title="app dashboard" />

    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
      Facilis explicabo adipisci aliquam officiis odit odio ut 
      repellat quae mollitia aut sint autem dolores, quos minus ipsam aperiam 
      fuga ipsa exercitationem.</p>
  </div>
</template>

<style scoped></style>
