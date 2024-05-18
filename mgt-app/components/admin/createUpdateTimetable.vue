<script  setup>
const timeSlot = ref({
    startingHour:'08',
    startingMinute:'00',
    endingHour:'12',
    endingMinute:"00",
    startingPeriod: 'AM',
    endingPeriod: 'PM'
})
const props = defineProps({
    passedItem:{
        type:String,
        default: null
    },
    dialogAction: {
        type: String,
        default: 'create'
    },
    showStatus:{
        type: Boolean,
        default: false
    }
})


function validateHour() {
  if (parseInt(timeSlot.value.startingHour) < 1) {
    timeSlot.value.startingHour = '1';
  } else if (parseInt(timeSlot.value.startingHour) > 12) {
    timeSlot.value.startingHour = '12';
  }
  if (parseInt(timeSlot.value.endingHour) < 1) {
    timeSlot.value.endingHour = '1';
  } else if (parseInt(timeSlot.value.endingHour) > 12) {
    timeSlot.value.endingHour = '12';
  }
}

function validateMinute() {
  if (parseInt(timeSlot.value.startingMinute) < 0) {
    timeSlot.value.startingMinute = '00';
  } else if (parseInt(timeSlot.value.startingMinute) > 59) {
    timeSlot.value.startingMinute = '59';
  }
  if (parseInt(timeSlot.value.endingMinute) < 0) {
    timeSlot.value.endingMinute = '00';
  } else if (parseInt(timeSlot.value.endingMinute) > 59) {
    timeSlot.value.endingMinute = '59';
  }
}

function updatePeriod() {
  // No need for validation here since we only have two options: AM or PM
}
const scheduleStore = useScheduleStore()
const globalStore = useGlobalDataStore()
const formData = ref({})
const initialize = async ()=> {
}
const statusList = ref([
    {value: 1,tag: "Passed"},
    {value: 2,tag: "On Going"},
    {value: 3,tag: "Coming"},

])

const handleForm = async ()=> {
    globalStore.toggleLoadingState('on')
    if(props.dialogAction === 'update'){
        formData.value.id = props.passedItem
    }
    formData.value.action = props.dialogAction
    formData.value.startTime = `${timeSlot.value.startingHour} : ${timeSlot.value.startingMinute} ${timeSlot.value.startingPeriod}`
    formData.value.endTime = `${timeSlot.value.endingHour} : ${timeSlot.value.endingMinute} ${timeSlot.value.endingPeriod}`
    // console.log(formData.value);
    const {error}  = await scheduleStore.createUpdateTimetable(formData.value)
    if(error.value){
        console.log(error.value);
    }
}
initialize()
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{'hide': !props.showStatus}" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-sky-100 w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.dialogAction}} Conference Timetable</h2>
        <form @submit.prevent="handleForm()">
            <pre>{{ props.passedItem }}</pre>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Select Conference Day</label>
                    <select v-model="formData.day_id" id="conference" 
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                        <option value="conference" disabled>Choose Status</option>
                        <option v-for="conferenceDay in scheduleStore.getConferenceDays" 
                        :key="conferenceDay.id" :value="conferenceDay.id">Day {{conferenceDay.label}} of {{ conferenceDay.conferenceYear }}</option>
                    </select>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Select Status</label>
                    <select v-model="formData.status" id="conference" 
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                        <option value="conference" disabled>Choose Status</option>
                        <option v-for="singleDay in statusList" 
                        :key="singleDay.tag" :value="singleDay.value">{{singleDay.tag}}</option>
                    </select>
                </div>
            </div>
            <div class="bg-sky-50 w-full my-2 p-2 rounded-lg flex justify-between">
                <div>
                    <p  class="text-lg text-gray-700">Starting Time</p>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="block">
                    <span class="text-gray-600">Hour</span>
                    <input type="number" class=" bg-white mx-2 w-16 border-2 rounded-md text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-1" 
                    placeholder="12" maxlength="2" pattern="1[012]|[1-9]" v-model="timeSlot.startingHour" @input="validateHour">
                    </label>                
                    <label class="block">
                    <span class="text-gray-600">Minute</span>
                    <input type="number" class=" bg-white mx-2 w-16 border-2 rounded-md text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-1" 
                    placeholder="00" maxlength="2" pattern="[0-9]|[0-5][0-9]" v-model="timeSlot.startingMinute" @input="validateMinute">
                    </label>
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <label class="flex items-center">
                    <input type="radio" class="form-radio text-blue-500" name="startingPeriod" value="AM" checked v-model="timeSlot.startingPeriod" @change="updatePeriod">
                    <span class="ml-2 text-sm text-gray-700">AM</span>
                    </label>
                    <label class="flex items-center">
                    <input type="radio" class="form-radio text-blue-500" name="startingPeriod" value="PM" v-model="timeSlot.startingPeriod" @change="updatePeriod">
                    <span class="ml-2 text-sm text-gray-700">PM</span>
                    </label>
                </div>
            </div>
            <div class="bg-sky-50 w-full my-2 p-2 rounded-lg flex justify-between">
                <div>
                    <p  class="text-lg text-gray-700">End Time</p>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="block">
                    <span class="text-gray-600">Hour</span>
                    <input type="number" class=" bg-white mx-2 w-16 border-2 rounded-md text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-1" 
                    placeholder="12" maxlength="2" pattern="1[012]|[1-9]" v-model="timeSlot.endingHour" @input="validateHour">
                    </label>                
                    <label class="block">
                    <span class="text-gray-600">Minute</span>
                    <input type="number" class=" bg-white mx-2 w-16 border-2 rounded-md text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-1" 
                    placeholder="00" maxlength="2" pattern="[0-9]|[0-5][0-9]" v-model="timeSlot.endingMinute" @input="validateMinute">
                    </label>
                </div>
                <div class="flex items-center space-x-2 mt-2">
                    <label class="flex items-center">
                    <input type="radio" class="form-radio text-blue-500" name="endingPeriod" value="AM" checked v-model="timeSlot.endingPeriod" @change="updatePeriod">
                    <span class="ml-2 text-sm text-gray-700">AM</span>
                    </label>
                    <label class="flex items-center">
                    <input type="radio" class="form-radio text-blue-500" name="endingPeriod" value="PM" v-model="timeSlot.endingPeriod" @change="updatePeriod">
                    <span class="ml-2 text-sm text-gray-700">PM</span>
                    </label>
                </div>
            </div>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i></button>
          <button @click="scheduleStore.toggleTimetableDialog('close')" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
                    hover:border-teal-700 text-sm border-4 text-white py-0.5 px-4 rounded"
                type="button">
                Close <i class="fa-regular fa-circle-xmark mx-2"></i>
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

</template>
<style scoped>
.hide {
    display: none;
}
</style>

  