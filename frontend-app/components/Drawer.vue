
<script lang="ts" setup>
import { ElMessageBox } from 'element-plus'
import type { DrawerProps } from 'element-plus'
const globalStore = useGlobalDataStore()
const drawer2 = ref(false)
const direction = ref<DrawerProps['direction']>('rtl')
const radio1 = ref('Option 1')
const handleClose = (done: () => void) => {
  ElMessageBox.confirm('Are you sure you want to close this?')
      .then(() => {
        done()
      })
      .catch(() => {
        // catch error
      })
}
function cancelClick() {
  globalStore.toggleRegistrationForm(false);
}
function confirmClick() {
  ElMessageBox.confirm(`Are you confirm to chose ${radio1.value} ?`)
      .then(() => {
        globalStore.toggleRegistrationForm(false);
      })
      .catch(() => {
        // catch error
      })
}

// --------------------
const formData = ref({firstName: '', middleName: '', lastName: '', email: '', password: '',})
const  inputType = ref('password');
const togglePasswordVisibility = () => {
  console.log(inputType.value)
  inputType.value = inputType.value === 'password' ? 'text' : 'password'
}
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const closeModal = () => {
  globalData.toggleRegistrationForm()
}
const handleRegistration = async () => {
  globalData.toggleLoadingState('on')
  await authStore.register(formData.value)
}
</script>
<template>
  <el-drawer
      v-model="globalStore.getRegistrationModalStatus"
      title="CREATE YOUR ACCOUNT"
      :direction="direction"
      :before-close="handleClose"
  >
    <div>
      <div class="flex  justify-center">
        <div class="bg-white align-middle  shadow-md rounded-lg md:px-10 px-8 py-2 my-1">
          <form @submit.prevent="handleRegistration()">
            <p class="my-2">To reserve your seat on the ICT Commission events, create your account</p>

            <div class="mb-4">
              <label for="firstNam" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
              <input type="text" id="firstNam" v-model="formData.firstName"
                     class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                     placeholder="Your first name" required>
            </div>
            <div class="mb-4">
              <label for="middleName" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
              <input type="text" id="middleName" v-model="formData.middleName"
                     class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                     placeholder="middle name">
            </div>
            <div class="mb-4">
              <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
              <input type="text" id="lastName" v-model="formData.lastName"
                     class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                     placeholder="last name" required>
            </div>
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
              <input type="email" id="email" v-model="formData.email"
                     class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                     placeholder="your@email.com" required>
            </div>
            <div class="mt-2 relative">
              <label class="block mt-2" for="email">Password</label>
              <input
                  :type="inputType"
                  v-model="formData.password"
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
            <button type="submit"
                    class="w-full flex justify-center mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
              Register
            </button>
          </form>
        </div>
      </div>
    </div>
  </el-drawer>
  <el-drawer v-model="drawer2" :direction="direction">
    <template #header>
      <h4>set title by slot</h4>
    </template>
    <template #default>
      <div>
        <div class="flex  justify-center">
          <div class="bg-white align-middle  shadow-md rounded-lg md:px-10 px-8 py-2 my-1">
            <form @submit.prevent="handleRegistration()">
              <p class="my-2">To reserve your seat on the ICT Commission events, create your account</p>

              <div class="mb-4">
                <label for="firstNam" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <input type="text" id="firstNam" v-model="formData.firstName"
                       class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="Your first name" required>
              </div>
              <div class="mb-4">
                <label for="middleName" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                <input type="text" id="middleName" v-model="formData.middleName"
                       class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="middle name">
              </div>
              <div class="mb-4">
                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <input type="text" id="lastName" v-model="formData.lastName"
                       class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="last name" required>
              </div>
              <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" v-model="formData.email"
                       class="block mt-2 w-full rounded-md border-1 py-2.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                       placeholder="your@email.com" required>
              </div>
              <div class="mt-2 relative">
                <label class="block mt-2" for="email">Password</label>
                <input
                    :type="inputType"
                    v-model="formData.password"
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
              <button type="submit"
                      class="w-full flex justify-center mt-4 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Register
              </button>
            </form>
          </div>
        </div>
      </div>
    </template>
  </el-drawer>
</template>
