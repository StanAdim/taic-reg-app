<script setup>
const props = defineProps({
  passedSchedule: {
    type: String,
    default: null
  },
  showStatus: {
    type: Boolean,
    default: false
  }
})

const formData = ref({firstName: '', middleName: '', lastName: '', email: '', password: '',})
const  inputType = ref('password');
const togglePasswordVisibility = () => {
  console.log(inputType.value)
  inputType.value = inputType.value === 'password' ? 'text' : 'password'
}
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const closeModal = () => {
  globalData.toggleRegistrationForm(false)
}
const handleRegistration = async () => {
  globalData.toggleLoadingState('on')
  globalData.toggleBtnLoadingState(true)
  await authStore.register(formData.value)
}
</script>
<template>
  <div class="fixed z-20  inset-0 overflow-y-auto rounded-lg mt-32 bg-black bg-opacity-80" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="bg-blue-100 rounded-lg px-2 shadow-xl">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             CREATE YOUR ACCOUNT
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
                <p class="my-2">To reserve your seat on the ICT Commission events, create your account</p>

                <div class="mb-4">
                  <label for="firstNam" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                  <input type="text" id="firstNam" v-model="formData.firstName"
                         class="input-form"
                         placeholder="Your first name" required>
                </div>
                <div class="mb-4">
                  <label for="middleName" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                  <input type="text" id="middleName" v-model="formData.middleName"
                         class="input-form"
                         placeholder="middle name">
                </div>
                <div class="mb-4">
                  <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                  <input type="text" id="lastName" v-model="formData.lastName"
                         class="input-form"
                         placeholder="last name" required>
                </div>
                <div class="mb-4">
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                  <input type="email" id="email" v-model="formData.email"
                         class="input-form"
                         placeholder="your@email.com" required>
                </div>
                <div class="mt-2 relative">
                  <label class="block mt-2" for="email">Password</label>
                  <input
                      :type="inputType"
                      v-model="formData.password"
                      id="password"
                      placeholder="***********"
                      class="input-form"
                      required
                  >
                  <button
                      @click.prevent="togglePasswordVisibility()"
                      type="button"
                      class="absolute inset-y-0 right-0 flex items-center top-8 px-3 text-gray-600"
                  >
                    <span v-if="inputType === 'password'">👁️</span>
                    <span v-else>👁️‍🗨️</span>
                  </button>
                </div>
                <button type="submit"
                        class="w-full flex justify-center mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                  Register <span class="px-2"><UsablesBtnLoader /></span>
                </button>
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
.input-form {
  @apply block mt-2 w-full rounded-md  py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
}
</style>