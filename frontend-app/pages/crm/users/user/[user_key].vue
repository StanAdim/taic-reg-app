<script setup lang="ts">
definePageMeta({middleware:'auth'})
import {
  ArrowDown,
  Check,
  CircleCheck,
  CirclePlus,
  CirclePlusFilled,
  Plus,
} from '@element-plus/icons-vue'

const userStore = useUserStore()
const authStore = useAuthStore()
const roleStore = useRoleStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const userData = ref(null)

const  isEditing = ref(false)
const toggleEditing =  async  () => isEditing.value = !isEditing.value

const updateData = async  () => {
  if (isEditing){
    const data = ref({
      email : userData.value?.user?.email
    })
    await  authStore.updateUserData(route.params.user_key,data.value)
  }
}
const handleRoleSwitch = async  (role) => {
  await authStore.updateUseRole(route.params.user_key,role.id)
  // console.log(role.id)
}
const init = async  ()=> {
  await userStore.retrieveSystemUserDetail(route.params.user_key)
  userData.value = userStore.getSystemUserDetail
  await  roleStore.retrieveSystemRoles()
}
onNuxtReady(()=> {
   init()
})
const goTo = () => navigateTo('/crm/users')
</script>

<template>
  <div class="mx-2">
      <AdminThePageTitle title="USER DETAILS"/>
    <!-- Container -->
    <template v-if="userData">
      <div class="max-w-4xl p-6 bg-white shadow-md rounded-lg mt-10">

        <!-- User Profile Header -->
        <div class="flex flex-wrap items-center  space-x-6">
          <img class="w-24 h-24 rounded-full" src="/speakers/placeholder.png" alt="User Avatar">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ userData?.user?.firstName }} {{userData?.user?.lastName}}</h1>
              <el-dropdown trigger="click">
                <span class="el-dropdown-link mx-2">
                  {{ userData?.user?.role }}<el-icon class="el-icon--right"> <ArrowDown /></el-icon>
                </span>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item @click="handleRoleSwitch(item)" v-for="item in roleStore.getSystemRoles" :icon="Plus">{{ item.name }}</el-dropdown-item>
                  </el-dropdown-menu>
                </template>
              </el-dropdown>
          </div>
        </div>

        <!-- User Details -->
        <div class="mt-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">User Information</h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Email
                <span class="font-bold" @click="toggleEditing">
                  <i v-if="!isEditing"  class="fa-solid fa-pen-to-square text-emerald-600 mx-2"></i>
                  <i v-else  class="fa-solid fa-check text-sky-600 mx-2"></i>
                </span>
              </p>
              <div>
                <!-- Conditionally render paragraph or input field -->
                <p
                    v-if="!isEditing"
                    class="text-gray-800"
                >
                  {{ userData?.user?.email || 'Click to add email' }}
                </p>

                <input
                    v-else
                    v-model="userData.user.email"
                    @blur="toggleEditing"
                    @keyup.enter="updateData"
                    class="text-sky-800 w-full border-b-2 border-teal-500 rounded-sm px-0.5 outline-none"
                />
              </div>
            </div>

            <div>
              <p class="text-gray-600 font-semibold">Professional Status</p>
              <p class="text-gray-800">{{ userData?.user?.userInfo?.professionalStatus }}</p>
            </div>
            <div>
              <p class="text-gray-600 font-semibold">Booked Events</p>
              <p class="text-gray-800">{{ userData?.subscriptions }}</p>
            </div>

            <div>
              <p class="text-gray-600 font-semibold">Bill Generated</p>
              <p class="text-gray-800">{{ userData?.bills }}</p>
            </div>
            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Phone</p>
              <p class="text-gray-800">{{  userData?.user?.userInfo?.phoneNumber }}</p>
            </div>

            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Address</p>
              <p class="text-gray-800">{{  userData?.user?.userInfo?.position }}, {{  userData?.user?.userInfo?.nation }}</p>
            </div>

            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold">Joined Date</p>
              <p class="text-gray-800">{{ userData?.user?.registrationDate}}</p>
            </div>
          </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4">About</h2>
          <p class="text-gray-700 leading-relaxed">...</p>
          <p class="text-gray-700 leading-relaxed"></p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
          <button @click="goTo()" class="px-4 py-0.5 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">Go back</button>
        </div>
      </div>
    </template>
    <div class="" v-else>
      <UsablesContentLoading />
    </div>
    </div>
</template>

<style scoped>

</style>