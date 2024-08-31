<script setup lang="ts">
const  inputType = ref('password');
const togglePasswordVisibility = () => {
  inputType.value = inputType.value === 'password' ? 'text' : 'password'
}
const globalData = useGlobalDataStore()
const authStore = useAuthStore()
const credentials = ref({ email:'', password: ''})
const handleLogin = async ()=>{
  if(credentials.value.password === '' && credentials.value.email === ''){
    return globalData.assignAlertMessage('Enter your email & password', 'error')
  }
  globalData.toggleLoadingState('on')
  await authStore.login(credentials.value)
}
const date = new Date();
</script>

<template>
  <div class="my-2 w-full">
    <forgot-password-modal :showStatus="globalData.getForgotPassModalStatus" />
    <register-modal :showStatus="globalData.getRegistrationModalStatus" />
    <div class="">
      <h2 class="font-bold text-xl text-sky-600">Please login to continue|</h2>
      <UsablesHanceLoader />
      <div class="mt-4 ">
        <form @submit.prevent="handleLogin()" class="w-full md:w-4/5">
          <div>
            <div class="mt-2 relative">
              <label class="block mt-2" for="email">Email</label>
              <input
                  type="text"
                  id="email"
                  placeholder="Email"
                  v-model="credentials.email"
                  class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  required
              >
            </div>
          </div>
          <div class="mt-2 relative">
            <label class="block mt-2" for="email">Password</label>
            <input
                :type="inputType"
                v-model="credentials.password"
                id="password"
                placeholder="***********"
                class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
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
          <div class="mt-4 flex w-full flex-col justify-between sm:flex-row">
            <!-- Forgot password -->
            <div>
              <p  @click="globalData.toggleForgotPassDialog()"
                  class="text-sm hover:cursor-pointer  hover:text-blue-800">Forgot password</p>
            </div>
          </div>
          <div class="my-6 text-white">
            <button class=" rounded-md bg-sky-600 w-fit px-16 py-3 hover:bg-sky-800">Login</button>
          </div>

        </form>
        <h2 class="font-light ">Don't have an account ? </h2>

        <div class="my-2 text-white">
          <button @click="globalData.toggleRegistrationForm(true)"
                  class="w-fit px-10 rounded-md bg-sky-400 py-2 hover:bg-sky-800">Register Here
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>