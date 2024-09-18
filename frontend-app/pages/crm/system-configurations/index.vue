<script setup lang="ts">
import ContentLoading from "~/components/usables/contentLoading.vue";

useHead({
    title: 'TAIC - Timetable'
})
definePageMeta({
  middleware:['auth','admin-role-checker']
})

const globalData = useGlobalDataStore()
const roleStore = useRoleStore()
import type { TabsPaneContext } from 'element-plus'

const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
  console.log(tab, event)
}
const init = async  ()=> {
   await roleStore.retrieveSystemPermissions()
   await roleStore.retrieveSystemRoles()
}
onNuxtReady(()=> {
  init()
})
const rolesHeader = [{name: "Name", key: 'name'}]
</script>
<template>
  <div class="">
    <AdminThePageTitle title="SYSTEM CONFIGURATIONS" />
    <div>
      <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">

        <el-tab-pane label="Role Configuration" name="first">
          <div class="">
            <p>Roles</p>
            <div class="">
              <template v-if="roleStore.getSystemRoles.length !== 0">
                <UsablesSimpleDataTable :headers="rolesHeader" :data="roleStore.getSystemRoles" />
              </template>
              <template v-else>
                <UsablesContentLoading />
              </template>
            </div>
          </div>

        </el-tab-pane>
        <el-tab-pane label="Gateway Systems" name="second">
          <div class="">
            <GatewaySytemList />
          </div>
        </el-tab-pane>
        <el-tab-pane label="Gepg Configuration" name="third">
          <div class="">
              <p>Gepg Configurations</p>
          </div>
            <div class=""></div>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>

</template>
<style>

</style>
