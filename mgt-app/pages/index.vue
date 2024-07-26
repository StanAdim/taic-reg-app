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
</script>
<template>
<!--  <usables-done-check-anim />-->
  <!-- component -->
  <div class="flex flex-col">
    <register-modal :showStatus="globalData.getRegistrationModalStatus" />
    <forgot-password-modal :showStatus="globalData.getForgotPassModalStatus" />
    <div class="">
        <div class="flex flex-row flex-wrap justify-center md:justify-between lg:justify-between w-full mt-5 md:mt-20">
          <div class=" w-full md:w-1/2 bg-white">
            <div class="mx-auto my-2 flex h-full w-2/3 flex-col justify-center text-blue-950 xl:w-1/2">
              <div class="my-2">
<!--                <p class="text-[30px]">ICT Commission {{ date.getUTCFullYear() }}</p>-->

                <h2 class="font-bold text-xl">Please login to continue|</h2>
                <usables-hance-loader />
              </div>

              <div class="mt-4">
                <form @submit.prevent="handleLogin()">
                  <div>
                    <label class="mb-2.5 block" for="email">Email</label>
                    <input type="email" id="email"  v-model="credentials.email"
                           class="inline-block w-full rounded-full bg-sky-100/40 p-3 leading-none text-black placeholder-zinc-600 shadow placeholder:opacity-50"
                           placeholder="Enter your email" />
                  </div>
                  <div class="mt-4">
                    <label class="mb-2.5 block" for="password">Password</label>
                    <input type="password" id="password"  v-model="credentials.password" placeholder="**********"
                           class="inline-block w-full rounded-full bg-sky-100/40 p-3 leading-none text-black placeholder-indigo-900 shadow" />
                  </div>
                  <div class="mt-4 flex w-full flex-col justify-between sm:flex-row">
                    <!-- Forgot password -->
                    <div>
                      <p  @click="globalData.toggleForgotPassDialog()"
                          class="text-sm hover:cursor-pointer  hover:text-blue-800">Forgot password</p>
                    </div>
                  </div>
                  <div class="my-6 text-white">
                    <button class="w-full rounded-full bg-sky-600 py-3 hover:bg-sky-800">Login</button>
                  </div>

                </form>
                <h2 class="font-light ">Don't have an account ? </h2>

                <div class="my-2 text-white">
                  <button @click="globalData.toggleRegistrationForm()" class="w-fit px-10 rounded-full bg-emerald-600 py-2 hover:bg-sky-800">Register Here</button>
                </div>
              </div>
            </div>
          </div>
          <div class="w-1/2 pr-10 bg-white hidden md:block lg:block">
            <div class=" w-full bg-white mt-10">
              <div class="flex-col justify-center">
                <LandingImageSlider />
              </div>
            </div>
<!--            <img src="/image/handling.png" class="h-full w-full" alt="img" />-->
          </div>
        </div>
    </div>
  </div>
</template>

<style scoped></style>
