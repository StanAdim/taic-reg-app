<script setup lang="ts">
definePageMeta({
  middleware:['auth']
})
import {
  ArrowDown,
  Check,
  CircleCheck,
  CirclePlus,
  CirclePlusFilled,
  Plus,
} from '@element-plus/icons-vue'

const speakerStore = useSpeakerStore()
const authStore = useAuthStore()
const roleStore = useRoleStore()
const globalStore = useGlobalDataStore()
const route = useRoute()
const speakerData = ref(null)
const config = useRuntimeConfig()
const apiBaseUlr = config.public.apiBaseUlr
const imageFullPath = (imgPath) => `${apiBaseUlr}/${imgPath}`
const init = async  ()=> {
  await speakerStore.retrieveSingleSpeaker(route.params.id)
  speakerData.value = speakerStore.getSpeakerData
}
onNuxtReady(()=> {
   init()
})
const goTo = () => navigateTo('/crm/speakers')
const handleVerification = async () => {
  await authStore.userEmailVerification(route.params.user_key)
}
</script>

<template>
  <div class="mx-2">
      <AdminThePageTitle title="SPEAKER'S DETAILS"/>
    <!-- Container -->
    <template v-if="speakerData">
      <div class="max-w-4xl p-6 bg-white shadow-md rounded-lg mt-10">

        <!-- User Profile Header -->
        <div class="flex flex-wrap items-center  space-x-6">
          <img class="w-24 h-24 rounded-full" :src="imageFullPath(speakerData?.imgPath)" alt="User Avatar">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ speakerData?.name }}</h1>
          </div>
        </div>

        <!-- User Details -->
        <div class="mt-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4"></h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <p class="text-gray-600 font-semibold">Company | Institution </p>
              <p class="text-gray-800">{{ speakerData?.institution }} </p>

            </div>
            <div>
              <p class="text-gray-600 font-semibold">Designation</p>
              <p class="text-gray-800">{{ speakerData?.designation }}</p>
            </div>
          </div>
        </div>
<!--        Additional Information-->
        <div class="mt-4">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4"> Presentation</h2>
          <p class="text-gray-700 leading-relaxed">Title:
          <span class="font-bold text-sky-600">{{ speakerData?.agenda_title }}</span>
          </p>
          <p class="text-gray-800">{{ speakerData?.agenda_desc }}</p>
        </div>
        <div class="mt-4">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4"> About Speaker</h2>
          <p class="text-gray-800">{{ speakerData?.brief_bio }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
          <button @click="goTo()" class="px-4 py-0.5 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600">Go back</button>
        </div>
      </div>
    </template>
    <div class="" v-else>
    </div>
    </div>
</template>

<style scoped>

</style>