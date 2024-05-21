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

const formData = ref({
  firstName:'',
  middleName:'',
  lastName:'',
  email:'',
  password:'',
})
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
    <div class="flex  justify-center">
      <div class="relative bg-blue-100 w-4/5 md:w-1/5 lg:w-2/5 rounded-lg px-2 shadow-xl">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
            Register Your Account
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="closeModal()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <div class="shadow-lg rounded-lg overflow-hidden">
            <!--     FORM       -->
            <form class="max-w-md p-6  my-2 px-2 border rounded-lg" @submit.prevent="handleRegistration()">
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="firstName">
                  First Name:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="firstName" type="text" v-model="formData.firstName" placeholder="First name">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="middleName">
                  Middle Name:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="middleName" type="text" v-model="formData.middleName" placeholder="Middle  name">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="lastName">
                 Last Name:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="lastName" type="text" v-model="formData.lastName" placeholder="Last name">
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">
                  Email:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="email" type="email" v-model="formData.email" placeholder="Enter your email">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">
                  Password:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="email" type="password" v-model="formData.password" placeholder="Enter your email">
              </div>
              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
              </button>
            </form>

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