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
const globalData = useGlobalDataStore()
const closeModal = ()=> {
  globalData.toggleRegistrationForm()
}
const handleRegistration = ()=> {
  console.log(formData.value)
}
</script>
<template>
  <div class="fixed z-20 inset-0 overflow-y-auto mt-1" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center">
      <div class="relative bg-blue-100 w-4/5 md:w-1/5 lg:w-2/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500">
          <div class=" bg-blue-50 pt-2 block text-xl font-bold text-blue-600 text-center"> CREATE ACCOUNT</div>
          <div class="shadow-lg rounded-lg overflow-hidden ">
            <!--     FORM       -->
            <form class="max-w-md mx-auto p-6  my-2 border rounded-lg shadow-lg" @submit.prevent="handleRegistration()">
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
          <div @click="closeModal" class="text-right my-2 mx-2">
            <i class="fa-solid fa-xmark bg-red-100 text-red-600 p-2 rounded-sm"></i>
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