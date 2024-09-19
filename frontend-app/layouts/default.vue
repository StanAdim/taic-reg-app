<script lang="ts" setup>

import UpdateUserInfoFormModal from "~/components/UpdateUserInfoFormModal.vue";

const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const accountStore = useAccountStore()
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
  <div>
    <user-info-form-modal :showStatus="globalData.getUserInfoModalStatus" />
    <UpdateUserInfoFormModal :showStatus="accountStore.getUserInfoUpdateDialogStatus" />
    <UpdateAccountModal :show-status="accountStore.getAccountUpdateDialogStatus" />
    <user-profile-modal :show-status="globalData.getUserProfileStatus" />

    <div class="flex w-screen h-screen text-gray-700">
      <!-- Sidebar -->
      <aside
          :class="{'hidden': hideSideBar}"
          class="flex flex-col w-64 border-r border-gray-300 bg-white"
      >
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-300 hover:bg-gray-100">
          <i class="fa fa-home-user text-lg"></i>
          <button @click="handleSidebar" class="focus:outline-none">
            <i class="fa fa-arrow-left text-lg"></i>
          </button>
        </div>

        <nav class="flex flex-col flex-grow p-4">
          <template v-if="authStore.getLoggedUser?.email_verified_at">
            <template v-for="route in sidebarRoutes">
              <nuxt-link
                  v-if="route.userRole === authStore.getUserRole || route.userRole === ''"
                  :key="route.path"
                  :to="route.path"
                  @click="handleLinkActive(route.path)"
                  class="flex items-center h-10 px-2 text-sm font-medium rounded-md border-b border-gray-200 hover:bg-sky-100 hover:text-gray-900"
              >
                <span>{{ route.name }}</span>
              </nuxt-link>
            </template>
          </template>
          <template v-else>
            <!-- Display an email verification prompt here if needed -->
          </template>
        </nav>
      </aside>

      <!-- Main content area -->
      <div class="flex flex-col flex-grow">
        <!-- Header -->
        <header class="flex items-center justify-between h-16 px-4 bg-gray-100 border-b border-blue-600/30">
          <button
              v-if="hideSideBar"
              @click="handleSidebar"
              class="p-2 bg-zinc-100 rounded-md hover:bg-sky-700 focus:outline-none"
          >
            <i class="fa fa-bars text-sky-400"></i>
          </button>

          <div class="hidden md:block text-lg font-medium">
            {{ authStore.getLoggedUser?.firstName }} {{ authStore.getLoggedUser?.lastName }}
          </div>

          <el-dropdown placement="bottom-start">
            <el-button>My Account</el-button>
            <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item @click.prevent="globalData.toggleUserProfileModalStatus">
                  <i class="fa fa-user pr-4"></i> Profile
                </el-dropdown-item>
                <el-dropdown-item @click="handleLogout">
                  <i class="fa-solid fa-lock pr-4"></i> Logout
                </el-dropdown-item>
              </el-dropdown-menu>
            </template>
          </el-dropdown>
        </header>

        <!-- Main content -->
        <main class="flex-grow p-6 overflow-auto bg-white">
          <template v-if="!authStore.getLoggedUser?.email_verified_at">
            <div class="flex items-center justify-between p-4 bg-red-100 rounded-md">
              <span class="text-gray-700">Your Email is not Verified</span>
              <button
                  @click="handleEmailVerificationRequest"
                  class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-md hover:bg-sky-800"
              >
                Request Verification
              </button>
            </div>
          </template>
          <template v-else>
            <div class="p-4 bg-sky-100 rounded-md">
              <slot />
            </div>
          </template>
        </main>
      </div>
    </div>
  </div>
</template>

<style scoped>
.router-link-active {
  @apply bg-sky-500 text-white;
}
</style>