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

const formData = ref({firstName:'', middleName:'',lastName:'', email:'',password:'',})
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const closeModal = ()=> {
  globalData.toggleRegistrationForm()
}
const handleRegistration = async ()=> {
  globalData.toggleLoadingState('on')
  await  authStore.register(formData.value)
}
</script>
<template>
  <div class="fixed z-20 inset-0 overflow-y-auto rounded-lg mt-32" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="relative bg-blue-100 rounded-lg px-2 shadow-xl">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             REGISTRATION
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="closeModal()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <!-- component -->
          <div class="flex  justify-center">
            <div class="bg-white align-middle  shadow-md rounded-lg md:px-10 px-8 py-2 my-1">
              <form @submit.prevent="handleRegistration()">
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