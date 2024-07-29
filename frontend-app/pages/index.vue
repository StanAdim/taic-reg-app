<script lang="ts" setup>
import HanceLoader from "~/components/usables/hanceLoader.vue";

definePageMeta({
  layout:'auth',
  middleware:'guest'
})
const globalData = useGlobalDataStore()
const authStore = useAuthStore()
const credentials = ref({ email:'', password: ''})
const handleLogin = async ()=>{
  if(credentials.value.password === '' && credentials.value.email === ''){
    return globalData.assignAlertMessage('Enter your email & password', 'error')
  }
  globalData.toggleLoadingState('on')
  const response = await authStore.login(credentials.value)
}
const date = new Date();
onNuxtReady(()=> {
})
</script>
<template>
<!--  <usables-done-check-anim />-->
  <!-- component -->
  <div class="flex flex-col">
    <register-modal :showStatus="globalData.getRegistrationModalStatus" />
    <forgot-password-modal :showStatus="globalData.getForgotPassModalStatus" />
    <div class="">
      <div class="grid grid-rows-2  md:grid-cols-3 mt-10 gap-2 md:gap-6  mx-10">
        <div class="col-span-2">
          <div class="  bg-white mt-4 md:mt-4 mr-5">
            <div class="flex-col justify-center">
              <LandingImageSlider />
            </div>
        </div>
          </div>
        <div class="my-2 w-full">
          <div class="">
            <h2 class="font-bold text-xl text-sky-600">Please login to continue|</h2>
            <usables-hance-loader />
            <div class="mt-4 ">
              <form @submit.prevent="handleLogin()">
                <div>
                  <label class="mb-2.5 block" for="email">Email</label>
                  <input type="email" id="email"  v-model="credentials.email"
                         class="inline-block w-full rounded-lg bg-sky-100/40 p-3 leading-none text-black placeholder-zinc-600 shadow placeholder:opacity-50"
                         placeholder="Enter your email" />
                </div>
                <div class="mt-4">
                  <label class="mb-2.5 block" for="password">Password</label>
                  <input type="password" id="password"  v-model="credentials.password" placeholder="**********"
                         class="inline-block w-full rounded-lg bg-sky-100/40 p-3 leading-none text-black placeholder-indigo-900 shadow" />
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
                <button @click="globalData.toggleRegistrationForm()"
                        class="w-fit px-10 rounded-md bg-sky-400 py-2 hover:bg-sky-800">Register Here
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped></style>
