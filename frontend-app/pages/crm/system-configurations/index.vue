<script setup lang="ts">
useHead({
    title: 'TAIC - Timetable'
})
definePageMeta({
    middleware:'auth'
})

const globalData = useGlobalDataStore()
import type { TabsPaneContext } from 'element-plus'

const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
  console.log(tab, event)
}

</script>
<template>
  <div class="">
    <AdminThePageTitle title="SYSTEM CONFIGURATIONS" />
    <div>
      <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">

        <el-tab-pane label="Role Configuration" name="first">
          <div class="">
            <p>Roles</p>
            <ul>
              <li></li>
            </ul>
          </div>

        </el-tab-pane>
        <el-tab-pane label="Task" name="second">
          <div class="">
              <p>System configurations</p>
          </div>

        </el-tab-pane>
      </el-tabs>
    </div>
  </div>

</template>
<style>

</style>
