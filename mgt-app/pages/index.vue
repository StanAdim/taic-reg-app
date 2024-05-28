<script lang="ts" setup>
definePageMeta({
  layout:'auth',
  middleware:'guest'
})
const globalData = useGlobalDataStore()
const authStore = useAuthStore()
const credentials = ref({
  email:'admin@example.com',
  password: 'password'
})
const handleLogin = async ()=>{
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
    <div class="">
        <div class="flex flex-row flex-wrap justify-center md:justify-between lg:justify-between w-full">
          <div class=" w-full md:w-1/2 bg-white">
            <div class="mx-auto flex h-full w-2/3 flex-col justify-center text-blue-950 xl:w-1/2">
              <div>
                <p class="text-xl">TAIC {{ date.getUTCFullYear() }} |
                  <span class="text-sm text-blue-600 hover:cursor-pointer p-1 border-b-2 m-2  rounded-md border-blue-500 hover:bg-sky-50"
                        @click="globalData.toggleRegistrationForm()">Register Now</span></p>
                <p>Please login to continue|</p>

              </div>

              <div class="mt-10">
                <form @submit.prevent="handleLogin()">
                  <div>
                    <label class="mb-2.5 block" for="email">Email</label>
                    <input type="email" id="email"  v-model="credentials.email"
                           class="inline-block w-full rounded-full bg-emerald-50 p-3 leading-none text-black placeholder-indigo-900 shadow placeholder:opacity-30"
                           placeholder="mail@user.com" />
                  </div>
                  <div class="mt-4">
                    <label class="mb-2.5 block" for="password">Password</label>
                    <input type="password" id="password"  v-model="credentials.password"
                           class="inline-block w-full rounded-full bg-emerald-50 p-3 leading-none text-black placeholder-indigo-900 shadow" />
                  </div>
                  <div class="mt-4 flex w-full flex-col justify-between sm:flex-row">
                    <!-- Forgot password -->
                    <div>
                      <a href="#" class="text-sm hover:text-gray-200">Forgot password</a>
                    </div>
                  </div>
                  <div class="my-10 text-white">
                    <button class="w-full rounded-full bg-sky-600 py-3 hover:bg-sky-800">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="w-1/2 bg-white hidden md:block lg:block">
            <img src="/image/handling.png" class="h-full w-full" alt="img" />
          </div>
        </div>
    </div>
  </div>
</template>

<style scoped></style>
