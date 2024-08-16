<script lang="ts" setup>
const globalStore = useGlobalDataStore()
const  asideOpen = ref(false);
const  profileOpen = ref(true);
const authStore = useAuthStore()
const sidebarLinks = ref([
    {name: 'Dashboard', path: '/crm/dashboard', icon:'fa-solid fa-house'},
    {name: 'Conferences', path: '/crm/configuration', icon:'fa-solid fa-gear'},
    {name: 'Schedules', path: '/crm/schedules', icon:'fa-brands fa-readme'},
    {name: 'Speakers', path: '/crm/speakers', icon:'fa-solid fa-person-chalkboard'},
    {name: 'Agenda', path: '/crm/agenda', icon:'fa-solid fa-list'},
    {name: 'Sponsors', path: '/crm/sponsors', icon:'fa-solid fa-sack-dollar'},
    {name: 'TimeTable', path: '/crm/timetable', icon:'fa-solid fa-calendar-days'},
    {name: 'Goe to Site', path: '/', icon:'fa-solid fa-tent-arrow-turn-left'},
])
</script>
<template>
<!-- page -->
<main class="min-h-screen w-full bg-sky-100 text-gray-700" x-data="layout">
    <!-- header page -->
    <header class="flex w-full items-center justify-between border-b-2 border-gray-200 bg-blue-400 p-2">
        <!-- logo -->
        <div class="flex items-center space-x-2 text-3xl">
            <button type="button" class=" " @click="asideOpen = !asideOpen"><i class="fa-solid fa-bars"></i></button>
            <div class="mx-20 font-bold text-white">
              <nuxt-link to="/crm/dashboard" class="text-gray-200 hover:text-teal-200 ">ICT Commission</nuxt-link>
            </div>
        </div>

        <!-- button profile -->
        <div>
            <button type="button" @click="profileOpen = !profileOpen"
                class="h-9 w-9 overflow-hidden rounded-full">
                <i class="fa-solid fa-user text-3xl"></i>
            </button>

            <!-- dropdown profile -->
            <div class="absolute right-2 mt-1 w-48 divide-y divide-gray-200 rounded-md border border-gray-200 bg-white shadow-md"
                :class="{'hidden':profileOpen}" x-transition>
                <div class="flex items-center space-x-2 p-2">
                  <div class="h-9 w-9 rounded-full">
                    <i class="fa-solid fa-user text-3xl"></i>
                  </div>
                    <div class="font-medium">{{authStore.user?.name}}</div>
                </div>

                <!-- <div class="flex flex-col space-y-3 p-2">
                    <a href="#" class="transition hover:text-teal-600">My Profile</a>
                    <a href="#" class="transition hover:text-teal-600">Edit Profile</a>
                    <a href="#" class="transition hover:text-teal-600">Settings</a>
                </div> -->

                <div class="p-2">
                    <button class="flex items-center space-x-2 transition hover:text-teal-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <div @click="authStore.logout">Log Out</div>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- aside -->
        <aside class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height:100dvh"
            :class="{'hidden':asideOpen}">
            <nuxt-link v-for="item in sidebarLinks" :key="item.name" :to="item.path" class="flex items-center space-x-1 rounded-md px-2 py-2 hover:bg-gray-100 hover:text-teal-600">
                <span class="text-xl mr-2"><i :class="item.icon"></i></span>
                <span>{{item.name}}</span>
            </nuxt-link>
           
        </aside>
        <admin-message-bar 
        :showStatus="globalStore.messageBarIsOpen" 
        :message="globalStore.notificationMessage"/>
        <!-- main content page -->
        <div class="w-full p-4">
            <template v-if="globalStore.isloading">
                <usables-spin-loader />
            </template>
          <slot />
        </div>
    </div>
</main>
</template>

<style scoped>
</style>