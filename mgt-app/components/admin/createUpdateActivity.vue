<script  setup>
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

const statusChecker = ref({
    hasPanelist: 0,
    hasMinActivity: 0,
    singlePanelist:''
})
const panelistList = ref([])
const handlePanelist = ()=>{
    panelistList.value.push(statusChecker.value.singlePanelist)
}
const handleRemovePanelis = (itemToRemove)=>{
    panelistList.value = panelistList.value.filter(item => item !== itemToRemove)
}

const scheduleStore = useScheduleStore()
const speakerStore = useSpeakerStore()
const globalStore = useGlobalDataStore()
const formData = ref({})
const day = ref({
    id: ''
})
const initialize = async ()=> {
    await speakerStore.retriveConferenceSpeakers();
}
let timeslots = ref([])
const handleTimeSlotCall = async (id)=> {
    const timetable = scheduleStore.getConferenceTimetables
    timeslots.value = timetable.filter(item => item.day_id === id)
    timeslots.value = Object.values(timeslots.value)
}
const handleForm = async ()=> {
    globalStore.setLoadingTo('on')
    if(props.dialogAction == 'update'){
        formData.value.id = props.passedItem
    }
    formData.value.action = props.dialogAction
    formData.value.hasPanelist = statusChecker.value.hasPanelist
    formData.value.hasMinActivity = statusChecker.value.hasMinActivity
    formData.value.panelist = panelistList.value
    const {error}  = await scheduleStore.createUpdateActivity(formData.value)
    formData.value = {}
    if(error.value)console.log(error.value)
}
initialize()
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{'hide': !props.showStatus}" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-sky-100 w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.dialogAction}} Conference Activity</h2>
        <form @submit.prevent="handleForm()">
            <!-- <pre>{{ scheduleStore.getConferenceDays }}</pre> -->
            <div class="mb-4 border-b-2 border-teal-500 py-2  mx-2">
                <label for="conference" class="block text-sm font-medium text-gray-700">Activity Date</label>
                <select v-model="day.id" id="conference" @change="handleTimeSlotCall(day.id)"
                class="bg-teal-100 border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="conference" disabled>Choose Day</option>
                    <option v-for="conferenceDay in scheduleStore.getConferenceDays" 
                    :key="conferenceDay.id" :value="conferenceDay.id">Date {{conferenceDay.date}} </option>
                </select>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Activity Time</label>
                    <select v-model="formData.timetable_id" id="conference" 
                    class="bg-teal-100 border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                        <option value="conference" disabled>Choose Time Slot</option>
                        <option v-for="conferenceTimetable in timeslots" 
                        :key="conferenceTimetable.id" :value="conferenceTimetable.id">Time {{conferenceTimetable.startTime}} - {{ conferenceTimetable.endTime }}</option>
                    </select>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Activity Name</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.name" placeholder="Programme Activity" id="name">
                </div>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Has Min Activity</label>
                    <div class="flex flex-row">
                        <div class="mx-1">
                            <label class="flex items-center">
                            <input type="radio" class="form-radio text-blue-500" name="hasMinActivity" value="1" checked v-model="statusChecker.hasMinActivity" >
                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                            </label>
                        </div>
                        <div class="mx-1">
                            <label class="flex items-center">
                            <input type="radio" class="form-radio text-blue-500" name="hasMinActivity" value="0" v-model="statusChecker.hasMinActivity">
                            <span class="ml-2 text-sm text-gray-700">No</span>
                            </label>
                        </div>
                    </div>
                    
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Has Panelist</label>
                    <div class="flex flex-row">
                        <div class="mx-1">
                            <label class="flex items-center">
                            <input type="radio" class="form-radio text-blue-500" name="hasPanelist" value="1" checked v-model="statusChecker.hasPanelist" >
                            <span class="ml-2 text-sm text-gray-700">Yes</span>
                            </label>
                        </div>
                        <div class="mx-1">
                            <label class="flex items-center">
                            <input type="radio" class="form-radio text-blue-500" name="hasPanelist" value="0" v-model="statusChecker.hasPanelist">
                            <span class="ml-2 text-sm text-gray-700">No</span>
                            </label>
                        </div>
                    </div>
                    
                </div>
               
            </div>
            
            <div class="mb-4 border-b-2 border-teal-500 py-2  mx-2" v-if="statusChecker.hasMinActivity == 1">
                <label for="subactivity" class="block text-sm font-medium text-gray-700">Min Activity</label>
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="text" v-model="formData.minActivity" placeholder="Activity Description" id="subactivity">
            </div>
            <template v-if="statusChecker.hasPanelist == 1">
                <div class="border-b-2 border-teal-500 py-2 mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Select Panelist</label>
                    <select  id="conference" @change="handlePanelist()" v-model="statusChecker.singlePanelist"
                    class=" bg-teal-100 border-none w-full text-gray-700 py-1 px-2 leading-tight focus:outline-none">
                        <option value="conference" disabled>Choose Speaker</option>
                        <option v-for="conferenceSpeaker in speakerStore.getSpeakers" 
                        :key="conferenceSpeaker.id" :value="conferenceSpeaker.name">{{conferenceSpeaker.name}} </option>
                    </select>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2  mx-2">
                    <label for="conference" class="block text-sm font-medium text-gray-700">Choose Moderator</label>
                    <select v-model="formData.moderator" id="conference" 
                    class=" bg-teal-100 border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                        <option value="conference" disabled>Choose Speaker</option>
                        <option v-for="conferenceSpeaker in speakerStore.getSpeakers" 
                        :key="conferenceSpeaker.id" :value="conferenceSpeaker.name">{{conferenceSpeaker.name}} </option>
                    </select>
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 mx-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Selected Panelist Names</label>
                    <p v-for="item in panelistList" :key="item" class=" my-2 border-none w-full text-gray-700  leading-tight "
                    >{{item}} <span @click="handleRemovePanelis(item)" class="bg-white p-0.5 my-0.5 ml-2 text-sm rounded-md "><i class=" text-red-600 fa-solid fa-trash"></i></span></p>
                </div>
            </template>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i></button>
          <button @click="scheduleStore.toogleActivityDialog('close')" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
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