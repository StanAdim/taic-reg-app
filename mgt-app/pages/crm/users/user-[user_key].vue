<script setup lang="ts">

definePageMeta({
  middleware:'auth'
})
const userStore = useUserStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const init = async  ()=> {
  await userStore.retrieveSystemUserDetail(route.params.user_key)
}
await init()
</script>

<template>
  <p>hello {{route.params.user_key}}</p>
</template>

<style scoped>

</style>