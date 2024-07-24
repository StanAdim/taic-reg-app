<script setup>
const props = defineProps({
  passedSchedule: {
    type:String,
    default: null
  },
  showStatus:{
    type: Boolean,
    default:false
  }
})
import { ElButton, ElDialog } from 'element-plus'
import { CircleCloseFilled } from '@element-plus/icons-vue'
const globalData = useGlobalDataStore()
const formData = ref({firstName:'', middleName:'',lastName:'', email:'',password:'',})
const authStore = useAuthStore()
const closeModal = ()=> {
  globalData.toggleRegistrationForm()
}
const handleRegistration = async ()=> {
  globalData.toggleLoadingState('on')
  await  authStore.register(formData.value)
}
</script>

<template>
  <el-dialog v-model="globalData.getRegistrationModalStatus" :show-close="false" width="500">
    <template #header="{ close, titleId, titleClass }">
      <div class="my-header">
        <h4 :id="titleId" :class="titleClass">ICT Commission Event System Registration</h4>
        <el-button type="danger" @click.prevent="globalData.toggleRegistrationForm()">
          Close
        </el-button>
      </div>
    </template>
    <div class="flex  justify-center">
      <div class="bg-white align-middle  shadow-md rounded-lg md:px-10 px-8 py-2 my-1">
        <form @submit.prevent="handleRegistration()">
          <p class="my-2">To reserve your seat on the ICTC events, create your account</p>

          <div class="mb-4">
            <label for="firstNam" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
            <input type="text" id="firstNam"  v-model="formData.firstName"
                   class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Your first name" required>
          </div>
          <div class="mb-4">
            <label for="middleName" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
            <input type="text" id="middleName"  v-model="formData.middleName"
                   class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="middle name">
          </div>
          <div class="mb-4">
            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
            <input type="text" id="lastName"  v-model="formData.lastName"
                   class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="last name" required>
          </div>
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email"  v-model="formData.email"
                   class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="your@email.com" required>
          </div>
          <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password"  v-model="formData.password"
                   class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                   placeholder="Enter your password" required>
          </div>
          <button  type="submit"
                   class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">Register</button>
        </form>
      </div>
    </div>
  </el-dialog>
</template>


<style scoped>
.my-header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  gap: 16px;
}
</style>
