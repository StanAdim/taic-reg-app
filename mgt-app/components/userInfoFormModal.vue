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
const authStore = useAuthStore()
const globalData = useGlobalDataStore()
const formData = ref({
  phoneNumber: '+255',
  user_id: authStore.getLoggedUser.id,
  professionalStatus: false,
  professionalNumber: '',
  institution: '',
  position: '',
  region_id: '0',
  district_id: '0',
})

const handleFormSubmission = async ()=> {
  globalData.toggleLoadingState('on')
  await  authStore.saveUserInfo(formData.value)
}
const handleDistrictsCall = async ()=>{
  await  globalData.retrieveRegionDistricts(formData.value.region_id)
}
const initialize = async () => {
  await  globalData.retrieveRegions()
}
initialize()
</script>
<template>
  <div class="fixed z-20 inset-0 overflow-y-auto mt-1 top-24" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center items-center">
      <div class="relative bg-blue-100 w-4/5 md:w-1/5 lg:w-2/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500">
          <div class=" bg-blue-50 pt-2 block text-xl font-bold text-sky-600 text-center">Complete registration</div>
          <div class="shadow-lg rounded-lg overflow-hidden ">
            <!--     FORM       -->
            <form class="max-w-md mx-auto p-6  my-2 border rounded-lg shadow-lg" @submit.prevent="handleFormSubmission()">
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="firstName">
                  Your Phone Number:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="firstName" type="text" v-model="formData.phoneNumber" placeholder="+255">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="professionalNumber">
                  Professional Number:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="professionalNumber" type="text" v-model="formData.professionalNumber" placeholder="">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="institution">
                  Institution | Company:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="institution" type="text" v-model="formData.institution" placeholder="Company | Institution">
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="position">
                  Position|Designation:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="position" type="text" v-model="formData.position" placeholder="Position|Designation">
              </div>
              <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="region_id" class="block text-sm font-medium text-gray-700">Select Region</label>
                <select v-model="formData.region_id" id="region_id" @change="handleDistrictsCall()"
                        class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none">
                  <option value="0" disabled>Choose region</option>
                  <option v-for="region in globalData.getRegions" :key="region" :value="region.id">{{region.name}}</option>
                </select>
              </div>
              <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="district_id" class="block text-sm font-medium text-gray-700">Select District</label>
                <select v-model="formData.district_id" id="district_id" class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none">
                  <option value="0" disabled>Choose District</option>
                  <option v-for="district in globalData.getDistricts" :key="district" :value="district.id">{{district.name}}</option>
                </select>
              </div>


              <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
              </button>
            </form>

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