<script setup lang="ts">
import {useSponsorshipStore} from "~/stores/useSponsorshipStore";

useHead({
    title: 'Conference - Sponsors'
})
definePageMeta({
    middleware:['auth', 'admin-role-checker']
})
const sponsorshipStore = useSponsorshipStore()
const globalData = useGlobalDataStore()
const eventStore = useEventStore()

const initDialog = ref(null);
const isUpdating  = ref(false)
const handleItemUpdate = (item) => {
  isUpdating.value = true
  sponsorshipStore.assignDataToBeUpdated(item)
  initDialog.value.initDialogData();
  sponsorshipStore.toggleSponsorModal(true)
}

const handleInitializing = async ()=>{
  await sponsorshipStore.retrieveConferenceSponsors()
  await  eventStore.retrieveEvents()
}
const openDialog = (method)=>{
  sponsorshipStore.toggleSponsorModal(true);
}
const activeName = ref('first')
const handleClick = (tab: TabsPaneContext, event: Event) => {
  // console.log(tab, event)
}
onNuxtReady(()=> {
  handleInitializing()
})
</script>
<template>
      <div class="">
        <AdminThePageTitle title="Conference Sponsors" />
        <AdminCreateSponsorshipModal ref="initDialog" :is-update-mode="isUpdating" />
        <div>
          <div class="flex flex-wrap justify-between flex-row border border-sky-100 rounded-md">
            <div class="mx-auto bg-white shadow-lg rounded-lg overflow-hidden w-full px-4 py-2">
              <div class="w-full max-w-sm mx-auto px-4 py-4">
                <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
                  <UsablesTheButton
                      v-if="globalData.hasPermission('can_manage_site')"
                      @click="openDialog('create')" :is-normal="true" name="New Sponsor"
                      iconClass="fa-solid fa-plus" />
                </div>
              </div>
              <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
<!--                Sponsors-->
                <el-tab-pane label="Sponsors" name="first">
                  <div class="">
                    <div class="text-sky-600 text-lg font-medium">Sponsors</div>
                    <div class="list-data">
                      <div class=" text-gray-900 " v-for="item in sponsorshipStore.getSponsors" :key="item.email">
                        <AdminSponsorshipCard :info="item" />
                      </div>
                    </div>
                  </div>
                </el-tab-pane>
<!--                Partners-->
                <el-tab-pane label="Partners" name="second">
                  <div class="">
                    <div class="text-sky-600 text-lg font-medium">Partners</div>
                    <div class="list-data">

                    </div>
                  </div>
                </el-tab-pane>
<!--                Exhibitors-->
                <el-tab-pane label="Exhibitors" name="third">
                  <div class="">
                    <div class="text-sky-600 text-lg font-medium">Exhibitors</div>
                    <div class="list-data">

                    </div>
                  </div>
                </el-tab-pane>
<!--                Others-->
<!--                <el-tab-pane label="Task" name="fourth">Task</el-tab-pane>-->
              </el-tabs>
            </div>
          </div>
        </div>
      </div>
</template>
<style scoped>
.demo-tabs > .el-tabs__content {
  padding: 32px;
  color: #6b778c;
  font-size: 32px;
  font-weight: 600;
}
.list-data {
  @apply flex flex-wrap
}
</style>
