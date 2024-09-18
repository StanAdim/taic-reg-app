<script setup lang="ts">

const systemStore = useGatewaySystemStore()

const systemHeader = [
    {name: "Name", key: 'name'},
    {name: "Code", key: 'code'},
    {name: "Desc", key: 'description'},
    {name: "Base", key: 'base_url'},
    {name: "ctrl_No URL", key: 'callback_controll_number'},
    {name: "payment URL", key: 'callback_payment_number'},
]

onNuxtReady(()=> {
  systemStore.retrieveRegisteredSystems()
})
</script>

<template>
    <div class="">
      <div class="w-full max-w-sm mx-auto px-4 py-2">
        <div class="flex justify-start items-center border-b-2 border-teal-500 py-2">
          <UsablesTheButton :is-normal="true" name="Add System" iconClass="fa-solid fa-plus" />
        </div>
      </div>
    <UsablesSimpleDataTable :headers="systemHeader" :data="systemStore.getRegisteredSystems" />
    </div>
</template>

<style scoped>

</style>