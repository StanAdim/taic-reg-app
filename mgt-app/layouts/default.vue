<script lang="ts" setup>

const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const handleLogout = async () => {
  globalData.toggleLoadingState('on')
  await authStore.logout()
}
const handleEmailVerificationRequest = async ()=> {
  globalData.toggleLoadingState('on');
  await  authStore.resendEmailVerification()
}
const hideSideBar = useLocalStorage(true,'showSideBar')
const handleSidebar = () => {
  return hideSideBar.value = !hideSideBar.value
}
const sidebarRoutes = globalData.getAppRoute
const handleLinkActive = (routeLink: string) => {
  globalData.setActiveLink(routeLink)
}

</script>

<template>
  <user-info-form-modal :showStatus="globalData.getUserInfoModalStatus"/>
  <user-profile-modal :show-status="globalData.getUserProfileStatus"/>
  <div class="">
    <!-- component -->
    <div class="flex w-screen h-screen text-gray-700">
      <!-- Component Start -->
      <div :class="{'hidden':hideSideBar}" class="flex flex-col w-[200px] border-r border-gray-300">
        <div class="relative text-sm focus:outline-none">
          <div class="flex items-center justify-between w-full h-16 px-4 border-b border-gray-300 hover:bg-gray-300">
            <i class="fa fa-home-user"></i>
            <span class="" @click="handleSidebar()">
                        <i class="fa fa-arrow-left"></i>
            </span>
          </div>
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-auto">
          <template v-if="authStore.getLoggedUser?.email_verified_at">
            <template v-for="route in sidebarRoutes">
              <nuxt-link  @click="handleLinkActive(route.path)"
                  v-if="route.userRole === authStore.getUserRole || route.userRole === ''"
                  :key="route"
                  :to="route.path"
                  :class="{'bg-sky-500 text-white': route.isActiveLink}"
                  class="flex items-center flex-shrink-0 h-10 border-b border-blue-500 hover:text-gray-900  px-2 text-sm font-medium rounded hover:bg-sky-100">
                <span class="leading-none">{{ route.name }}</span>
              </nuxt-link>
            </template>
          </template>
          <template v-else>
            <p class="text-sm text-white bg-red-600 px-2 py-0.5 rounded-md text-center">Verify your Email First</p>
          </template>

<!--          <a class="flex items-center flex-shrink-0 h-10 px-3 mt-auto text-sm font-medium bg-gray-200 rounded hover:bg-emerald-300"-->
<!--             href="#">-->
<!--            <i class="fa fa-plus"></i>-->
<!--            <span class="ml-2 leading-none">New Item</span>-->
<!--          </a>-->
        </div>

      </div>
      <div class="flex flex-col flex-grow">
        <div class="flex items-center justify-end flex-shrink-0 h-16 px-1 border-b border-gray-300 bg-gray-100">
          <span :class="{'hidden': !hideSideBar}" class="bg-zinc-100 rounded-md hover:cursor-pointer hover:bg-sky-700 p-0.5 "
                @click="handleSidebar()">
            <i class="fa fa-bars mx-2 text-sky-400"></i></span>
          <div class="hidden md:block text-lg font-medium ml-2"><i
              class="fa fa-user mx-1"></i>{{ authStore.getLoggedUser?.firstName }}
            {{ authStore.getLoggedUser?.lastName }}
          </div>
          <div class="hidden md:block  font-thin ml-2">
            <nuxt-link to="#"><i class="fa fa-angles-left mx-2"></i></nuxt-link>
          </div>
          <div :class="{'hidden': !hideSideBar}"
               class="flex items-center justify-center h-10 px-4 ml-auto text-sm font-medium rounded ">
          </div>

          <div class=" ml-2 text-sm focus:outline-none group">
              <span class="w-full px-4 py-2 text-left hover:bg-sky-600 hover:text-white rounded-md"
                 @click.prevent="globalData.toggleUserProfileModalStatus()"
              ><i class="fa fa-user px-2"></i> Profile
              </span>
              <span  class="w-full px-4 py-2 text-left hover:bg-red-600 hover:text-white hover:cursor-pointer justify-center text-sm font-medium bg-red-100  rounded"
                 @click="handleLogout()"><i class="fa-solid fa-lock mx-1"></i>Logout
              </span>
          </div>
        </div>
        <div class="flex-grow p-6 overflow-auto bg-white">
          <template v-if="!authStore.getLoggedUser?.email_verified_at">
            <div>
              <p class="">
                <i></i>
                <span class="mx-2 ">Your Email is not Verified</span>
                <span class="text-sm text-white bg-sky-600 hover:bg-sky-800 px-4 py-2 rounded-md text-center"
                      @click="handleEmailVerificationRequest"
                >Request verification</span>
              </p>
            </div>

          </template>
          <template v-else>
            <div class="bg-sky-100 mx-1 px-4 py-2">
                <slot/>
            </div>
          </template>
        </div>
      </div>
      <!-- Component End  -->
    </div>
  </div>
</template>

<style scoped>

</style>
