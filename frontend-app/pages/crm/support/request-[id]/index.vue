<script setup lang="ts">
definePageMeta({
  middleware:['auth','admin-role-checker']
})
import {
  ArrowDown,
  Check,
  CircleCheck,
  CirclePlus,
  CirclePlusFilled,
  Plus,
} from '@element-plus/icons-vue'

const supportStore = useSupportActionStore()
const authStore = useAuthStore()
const globalStore = useGlobalDataStore()
const route = useRoute()

const  isEditing = ref(false)
const toggleEditing =  async  () => isEditing.value = !isEditing.value

const handlePostingResponse = async  () => {
  if (isEditing){
    const data = ref({
      response : formData.value?.response,
      supportRequestId :route.params.id
    })
    await  supportStore.createResponseToRequest(data.value)
    // isEditing.value = false
  }
}

const formData = ref( {response: ''})
const requestData = ref(null)
const init = async  ()=> {
  await supportStore.triggerSingleRequest(route.params.id)
  requestData.value = supportStore.getSingleSupportRequest
}
onNuxtReady(()=> {
   init()
})
const goTo = () => navigateTo('/crm/support')

</script>

<template>
  <div class="mx-2">
    <UsablesContentLoading />
    <AdminThePageTitle title="ISSUE RAISED DETAILS"/>
    <!-- Container -->
      <div class="max-w-4xl p-6 bg-white shadow-md rounded-lg mt-10">

        <!-- User Profile Header -->
        <div class="flex flex-wrap items-center  space-x-6">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{supportStore.getSingleSupportRequest?.subject}}</h1>
          </div>
        </div>

        <!-- User Details -->
        <div class="mt-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">MESSAGE</h2>
          <p>{{supportStore.getSingleSupportRequest?.message}}</p>

          <div class="">
            <!-- Detail Item -->
            <div>
              <p class="text-gray-600 font-semibold mx-2 my-1">Response
                <span class="font-bold">
                  <i v-if="!isEditing"  class="fa-solid fa-pen-to-square text-emerald-600 mx-2"></i>
                  <i v-else  class="fa-solid fa-check text-sky-600 mx-2"></i>
                </span>
              </p>
              <div>
                <!-- Conditionally render paragraph or input field -->
                <span
                    @click="toggleEditing"
                    v-if="!isEditing"
                    class="bg-emerald-500 text-white py-1 px-2 rounded-lg hover:cursor-pointer hover:bg-emerald-600"
                >
                  {{ requestData?.user?.email || 'Respond now' }}
                </span>

                <form v-else  @submit.prevent="handlePostingResponse">
                  <textarea
                      rows="4"
                      v-model="formData.response"
                      @blur="toggleEditing"
                      class="text-sky-800 w-full border-b-2 border-teal-500 rounded-sm px-0.5 outline-none"
                  />
                  <button type="submit" class="px-4 py-0.5 bg-blue-500 text-white font-semibold rounded-md hover:bg-gray-600">Submit</button>
                </form>

              </div>
            </div>



<!--            &lt;!&ndash; Detail Item &ndash;&gt;-->
<!--            <div>-->
<!--              <p class="text-gray-600 font-semibold">Address</p>-->
<!--              <p class="text-gray-800">{{  requestData?.user?.userInfo?.region?.name }},{{ requestData?.user?.userInfo?.district?.name }}</p>-->
<!--                <p class="text-gray-800">{{  requestData?.user?.userInfo?.nation }}</p>-->
<!--            </div>-->

          </div>
        </div>

        <!-- Additional Information -->
<!--        <div class="mt-8">-->
<!--          <h2 class="text-2xl font-semibold text-gray-800 mb-4">About</h2>-->
<!--          <p class="text-gray-700 leading-relaxed">...</p>-->
<!--          <p class="text-gray-700 leading-relaxed"></p>-->
<!--        </div>-->

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
<!--          <button @click="handleVerification()" class="px-2 py-0.5 bg-sky-500 text-white font-semibold rounded-md hover:bg-sky-600">Verify User</button>-->
          <button @click="goTo()" class="px-4 py-0.5 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">Go back</button>
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>