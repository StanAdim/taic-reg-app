<script setup>
const props = defineProps({
  passedUserInfo: {
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
  user_id: authStore.getLoggedUser?.id,
  professionalStatus: '0',
  professionalNumber: '',
  address: '',
  nation: 214,
  notificationConsent: '',
  email: '',
  institution: '',
  position: '',
  region_id: '0',
  district_id: '0',
})

const handleFormSubmission = async ()=> {
  if(formData.value.district_id === '0'){
    return globalData.assignAlertMessage(['Select District'],'danger')
  }
  globalData.toggleLoadingState('on')
  await  authStore.saveUserInfo(formData.value)
}
const handleDistrictsCall = async ()=>{
  await  globalData.retrieveRegionDistricts(formData.value.region_id)
}
const showProfessionalInfo = ref(false)
const closeProfessionalInfo = ()=> {showProfessionalInfo.value = false}
const getShowProfessionalInfo = computed(()=> {return showProfessionalInfo.value})
const handleCallProfessionalDetails = async (professionalCode)=>{
  showProfessionalInfo.value = true
  globalData.toggleLoadingState('on')
  await authStore.verifyProfessionalNumber(professionalCode)
  // console.log(professionalCode)
}

const initialize = async () => {
  await  globalData.retrieveRegions()
  await  globalData.retrieveNations()
}
initialize()
</script>
<template>
  <div class="fixed z-[40] inset-0 overflow-y-auto mt-1 top-32" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center items-center">
      <div class="relative bg-blue-100 w-4/5 md:w-1/5 lg:w-2/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500">
          <div class=" bg-blue-50 pt-2 block text-xl font-bold text-sky-600 text-center">COMPLETE REGISTRATION</div>
          <UsablesHanceLoader />
          <div class="shadow-lg rounded-lg overflow-hidden ">
            <!--     FORM       -->
            <form class="max-w-md mx-auto p-6  my-2 border rounded-lg shadow-lg" @submit.prevent="handleFormSubmission()">
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="phoneNumber">
                  Your Phone Number:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="phoneNumber" type="text" v-model="formData.phoneNumber" placeholder="+255">
              </div>

              <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                <label for="conference" class="block text-sm font-medium text-gray-700">Are you Registered ICT Professional ?</label>
                <div class="flex flex-row">
                  <div class="mx-1">
                    <label class="flex items-center">
                      <input type="radio" class="form-radio text-blue-500" name="professionalStatus" value="1" checked v-model="formData.professionalStatus" >
                      <span class="ml-2 text-sm text-gray-700">Yes</span>
                    </label>
                  </div>
                  <div class="mx-1">
                    <label class="flex items-center">
                      <input type="radio" class="form-radio text-blue-500" name="professionalStatus"  value="0" v-model="formData.professionalStatus">
                      <span class="ml-2 text-sm text-gray-700">No</span>
                    </label>
                  </div>
                </div>
              </div>
                <template v-if="formData.professionalStatus === '1'">
                    <div class="mb-4" >
                      <label class="block text-gray-700 font-bold mb-2" for="professionalNumber">Professional Number:</label>
                      <input @change="handleCallProfessionalDetails(formData.professionalNumber)"
                          class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                             id="professionalNumber" type="text" v-model="formData.professionalNumber" placeholder="">
                    </div>
                    <div v-if="getShowProfessionalInfo"
                        class="mb-2 bg-amber-50 px-3 py-0.5 rounded-sm border-b-2 border-teal-500">
                      <div class="flex flex-row justify-between">
                          <p class="block text-sm font-medium text-gray-700">{{ authStore.getProfessionalDetails?.name || '' }}</p>
                          <p class="bg-blue-500 hover:bg-blue-800 px-1 py-0.5 rounded-lg text-white"
                          @click="closeProfessionalInfo"
                          >Confirm</p>
                      </div>
                    </div>
                </template>
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
                <label for="region_id" class="block text-sm font-medium text-gray-700">Nationality</label>
                <select v-model="formData.nation" id="region_id"
                        class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none">
                  <option value="0" disabled>Choose region</option>
                  <option v-for="nation in globalData.getNations" :key="nation" :value="nation.id">{{nation.name}}</option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="position">
                  Physical Address:
                </label>
                <input class="appearance-none rounded-md  w-full text-gray-700 mr-3 py-2 px-2 leading-tight focus:outline-none border-b-2 border-teal-500"
                       id="position" type="text" v-model="formData.address" placeholder="Position|Designation">
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

              <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                <label for="conference" class="block text-sm font-medium text-gray-700">Receive updates regarding  our events and related activities ?</label>
                <div class="flex flex-row">
                  <div class="mx-1">
                    <label class="flex items-center">
                      <input type="checkbox" class="form-radio text-blue-500" checked v-model="formData.notificationConsent" >
                      <span class="ml-2 text-sm text-gray-700">Yes</span>
                    </label>
                  </div>
                </div>
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