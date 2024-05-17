<script lang="ts" setup>
definePageMeta({
    layout:'guest',
    middleware: 'guest'
})
useHead({
  title: 'TAIC - Login'
})

const hasError = ref(false)
const errorMessage = ref('')
const authStore = useAuthStore()
const globalStore = useGlobalDataStore()
const loginCredential = ref({
  email: 'test@mail.com',
  password: '123456'
})
const handleLogin = async ()=> {
    globalStore.setLoadingTo('on')
    if(authStore.isLoggedIn) return
    const {error} = await authStore.login(loginCredential.value)
    //  console.log(error.value)
  if(error.value?.data){
    globalStore.setLoadingTo('off')
    hasError.value = true
    errorMessage.value = error.value?.data?.message
  }
}
</script>

<template>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-20 w-auto" src="/logo/ictc.png" alt="Workflow">
        <p class="mt-2 text-center text-2xl leading-5 text-sky-400 font-bold max-w">
            TAIC ADMIN PANEL
        </p>
    </div>


    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form @submit.prevent="handleLogin()">
                <UsablesSpinLoader v-if="globalStore.isloading" />
                <div>
                    <label for="email" class="block text-sm font-medium leading-5  text-gray-700">Email address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="email" v-model="loginCredential.email" placeholder="user@example.com" type="email" 
                         class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none 
                         focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        <div :class="{'hidden': !hasError}" class=" absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="password" 
                        v-model="loginCredential.password"
                         type="password" 
                         class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md
                          placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 
                          transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    </div>
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Login     
                        </button>
                    </span>
                </div>
                <div class="alert" v-if="hasError">
                    <p class="my-0.5 p-0 text-red-500">{{ errorMessage}}</p>
                </div>
            </form>

        </div>
    </div>
</div>
</template>

<style scoped>
.alert {
    @apply bg-red-50 py-0 my-2 px-2 text-center;
}
.password {
    
}
</style>
