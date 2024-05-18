<script lang="ts" setup>

const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const handleLogout = async  () => {
  await authStore.logout()
}

const hideSideBar = ref(true)
const handleSidebar = ()=> {
  return hideSideBar.value = !hideSideBar.value
}

const sidebarRoutes = ref([
  {name: 'Dashboard', path: '/crm/', userRole:''},
  {name: 'All Events', path: '/crm/events', userRole:''},
  {name: 'Key Speakers', path: '/crm/speakers', userRole:'admin'},
  {name: 'Payments', path: '/crm/speakers', userRole:''},
  {name: 'Schedules', path: '/crm/schedules', userRole:'admin'},
  {name: 'Users', path: '/crm/users', userRole:'admin'},
  {name: 'Agenda', path: '/crm/agenda', userRole:'admin'},
])
</script>

<template>
  <user-info-form-modal :showStatus="globalData.getUserInfoModalStatus" />
  <user-profile-modal :show-status="globalData.getUserProfileStatus" />
  <div class="">
    <!-- component -->
    <div class="flex w-screen h-screen text-gray-700">
      <!-- Component Start -->
      <div class="flex flex-col w-56 border-r border-gray-300" :class="{'hidden':hideSideBar}">
        <div class="relative text-sm focus:outline-none">
          <div class="flex items-center justify-between w-full h-16 px-4 border-b border-gray-300 hover:bg-gray-300">
                        <i class="fa fa-home-user"></i>
            <span @click="handleSidebar()" class="">
                        <i class="fa fa-arrow-left"></i>
            </span>
          </div>
        </div>
        <div class="flex flex-col flex-grow p-4 overflow-auto">
          <template v-for="route in sidebarRoutes">
              <nuxt-link
                  v-if="route.userRole === authStore.getUserRole || route.userRole === ''"
                  :key="route"
                  :to="route.path"
                  class="flex items-center flex-shrink-0 h-10 border-b border-blue-500  px-2 text-sm font-medium rounded hover:bg-sky-100" >
                <span class="leading-none">{{ route.name }}</span>
              </nuxt-link>
          </template>

          <a class="flex items-center flex-shrink-0 h-10 px-3 mt-auto text-sm font-medium bg-gray-200 rounded hover:bg-emerald-300"
             href="#">
            <i class="fa fa-plus"></i>
            <span class="ml-2 leading-none">New Item</span>
          </a>
        </div>

      </div>
      <div class="flex flex-col flex-grow">
        <div class="flex items-center justify-end flex-shrink-0 h-16 px-1 border-b border-gray-300 bg-gray-100">
          <span @click="handleSidebar()" :class="{'hidden': !hideSideBar}" class="bg-zinc-100 rounded-md hover:cursor-pointer hover:bg-sky-700 p-0.5 ">
            <i class="fa fa-bars mx-2 text-sky-400"></i></span>
          <div class="hidden md:block text-lg font-medium ml-2"><i class="fa fa-user mx-1"></i>{{authStore.getLoggedUser?.firstName}} {{authStore.getLoggedUser?.lastName}}</div>
          <div class="hidden md:block  font-thin ml-2"><nuxt-link to="#"><i class="fa fa-angles-left mx-2"></i></nuxt-link></div>
          <div class="flex items-center justify-center h-10 px-4 ml-auto text-sm font-medium rounded " :class="{'hidden': !hideSideBar}">
          </div>
          <button class="relative ml-2 text-sm focus:outline-none group">
            <div class="flex items-center justify-between w-10 h-10 rounded hover:bg-gray-300">
              <span class="w-5 h-5 mx-auto">
                <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
              </span>
            </div>
            <div class="absolute right-0 flex-col items-start hidden w-40 pb-1 bg-white border border-gray-300 shadow-lg group-focus:flex">
              <p class="w-full px-4 py-2 text-left hover:bg-sky-100 rounded-md border-2 hover:border-blue-500"
              @click.prevent="globalData.toggleUserProfileModalStatus()"
              >Your Profile</p>
              <p class="w-full px-4 py-2 text-left  hover:cursor-pointer justify-center border-2 text-sm font-medium bg-orange-50  rounded hover:border-orange-600"
                 @click="handleLogout()"><i class="fa fa-hand-point-left"></i>Logout</p>
            </div>
          </button>
        </div>
        <div class="flex-grow p-6 overflow-auto bg-white">
             <slot />
        </div>
      </div>
      <!-- Component End  -->

    </div>

  </div>
</template>

<style scoped>

</style>
