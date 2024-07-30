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
const user = authStore.getLoggedUser?.user_info

const accountStore = useAccountStore()
const globalData = useGlobalDataStore()
const formData = ref({
  phoneNumber: user?.phoneNumber,
  info_id: user?.id,
  professionalStatus: user?.professionalStatus,
  professionalNumber: user?.professionalNumber,
  institution: user?.institution,
  position: user?.position,
  region_id: user?.region_id,
  district_id:'',
  address: user?.address,
  nation: user?.nation,
  notificationConsent: user?.notificationConsent,
})

const handleFormSubmission = async ()=> {
  globalData.toggleLoadingState('on')
  await accountStore.handleUserAccountUpdate(formData.value, 'information')
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
  try {
    // await  globalData.retrieveLocation()
    console.log('Confirm')
  } catch (error) {
    console.error('Error retrieving regions:', error);
    throw error; // Rethrow if you want the caller to handle it
  }}
initialize()
</script>
<template>
  <div class="fixed z-[60] inset-0 overflow-y-auto mt-1 top-32" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center items-center">
      <div class="relative bg-blue-100 w-4/5 md:w-1/5 lg:w-2/5 rounded-lg shadow-xl py-2">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             UPDATE YOUR INFORMATION
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="accountStore.toggleUpdateUserInfoDialogState('off')"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
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
              <template v-if="formData.nation === 214">
                <div class="mb-4 border-b-2 border-teal-500 py-2">
                  <label for="region_id" class="block text-sm font-medium text-gray-700">Select Region</label>
                  <select v-model="formData.region_id" id="region_id" @change="handleDistrictsCall()"
                          class="input-custom">
                    <option value="0" disabled>Choose region</option>
                    <option v-for="region in globalData.getRegions" :key="region" :value="region.id">{{region.name}}</option>
                  </select>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2">
                  <label for="district_id" class="block text-sm font-medium text-gray-700">Select District</label>
                  <select v-model="formData.district_id" id="district_id" class="input-custom">
                    <option value="0" disabled>Choose District</option>
                    <option v-for="district in globalData.getDistricts" :key="district" :value="district.id">{{district.name}}</option>
                  </select>
                </div>
              </template>

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
                Update
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