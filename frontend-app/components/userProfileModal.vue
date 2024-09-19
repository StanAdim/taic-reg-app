<script setup>
const props = defineProps({
  showStatus: {
    type: Boolean,
    default: false
  }
})
const authStore = useAuthStore()
const accountStore = useAccountStore()
const globalData = useGlobalDataStore()
const userProfile = ref(null)
const initialize = async () => {
  userProfile.value = authStore.getLoggedUser
}
const handleOpeningAccountEdit = async () => {
  if (authStore.getLoggedUser){
    accountStore.toggleAccountDialogState('on')
  }else globalData.assignAlertMessage('User Not found', 'warning')
}
const handleUserDetailUpdateModal = async () => {
  if (authStore.getLoggedUser){
    accountStore.toggleUpdateUserInfoDialogState('on')
  }else globalData.assignAlertMessage('User Not found', 'warning')
}
initialize()
</script>
<template>
  <div id="modal" :class="{'hide': !props.showStatus}" class="fixed z-20 inset-0 overflow-y-auto mt-1 top-32 bg-black bg-opacity-60">
    <div class="flex  justify-center items-center">
      <div class="relative bg-blue-100 w-full md:w-3/5 lg:w-3/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500 flex justify-between items-center py-1">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             PROFILE INFO
          </span>
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
            @click="globalData.toggleUserProfileModalStatus()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
        </div>
          <div class=" my-2 mx-2 p-1 ">
            <button @click.prevent="handleOpeningAccountEdit()" class="mx-1 h-8 w-auto bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-0.5 px-2 rounded" type="button">
               Account <i class="fa-regular fa-pen-to-square mx-1"></i>
            </button>
            <button @click.prevent="handleUserDetailUpdateModal()" class="mx-1 h-8 w-auto bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-0.5 px-2 rounded" type="button">
               User Info <i class="fa-regular fa-pen-to-square mx-1"></i>
            </button>
            <div class="bg-white rounded-lg shadow-md p-6 my-2 text-center">
              <div class="flex flex-wrap justify-evenly items-center">
                <div class=" mx-3">
                  <img src="/speakers/placeholder.png" alt="Team Member 2" class="max-w-48 rounded-full mb-4">
                </div>
                <div class="flex-grow bg-sky-50 px-8 py-2">
                  <h3 class="text-xl font-semibold text-sky-600 mb-2">
                    <span class=""></span>{{ userProfile?.firstName }}  <span class=""></span>{{ userProfile?.middleName }}  <span class=""></span>{{ userProfile?.lastName }}</h3>
                  <div class="text-gray-700">Email: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{ userProfile?.email }}</span></div>
                  <template v-if="authStore.getLoggedUserInfo">
                  <div class="text-gray-700">Phone Number: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.phoneNumber}}</span></div>
                    <div class="text-gray-700">Institution: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.institution}}</span></div>
                    <div class="text-gray-700">Designation: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.position}}</span></div>
                    <div class="text-gray-700">Professional Status <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.professionalStatus}}</span></div>
                    <div class="text-gray-700">Professional number: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.professionalNumber || '...'}}</span></div>
                    <div class="text-gray-700">Address: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.region?.name || ''}} - {{authStore.getLoggedUserInfo?.district?.name || ''}} </span></div>
                    <div class="text-gray-700">Nationality: <br><span class="bg-sky-200 rounded-md px-2 py-0.5">{{authStore.getLoggedUserInfo?.nation}} </span></div>
                  </template>
                </div>
              </div>
            </div>
                <p></p>
            <p></p>
          </div>

      </div>
    </div>
  </div>
</template>
<style scoped>
.hide {
  display: none;
}
</style>