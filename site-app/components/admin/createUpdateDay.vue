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
const Daylabels = ref([
    {value: 1,tag: "Day 1"},
    {value: 2,tag: "Day 2"},
    {value: 3,tag: "Day 3"},
    {value: 4,tag: "Day 4"},
    {value: 5,tag: "Day 5"},
])
const statusList = ref([
    {value: 1,tag: "Passed"},
    {value: 2,tag: "On Going"},
    {value: 3,tag: "Coming"},

])
const scheduleStore = useScheduleStore()
const conferenceStore = useConfigurationStore()
const globalStore = useGlobalDataStore()
const formData = ref({})
const initialize = async ()=> {
    await conferenceStore.retriveConferences();
}
const handleForm = async ()=> {
    globalStore.setLoadingTo('on')
    if(props.dialogAction == 'update'){
        formData.value.id = props.passedItem
    }
    formData.value.action = props.dialogAction
    const {error}  = await scheduleStore.createUpdateDay(formData.value)
    console.log(error.value)
}
initialize()
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{'hide': !props.showStatus}" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-sky-100 w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.dialogAction}} Conference Day</h2>
        <form @submit.prevent="handleForm()">
            <pre>{{ props.passedItem }}</pre>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="conference" class="block text-sm font-medium text-gray-700">Select Conference</label>
                <select v-model="formData.conference_id" id="conference" 
                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="conference" disabled>Choose Year</option>
                    <option v-for="conference in conferenceStore.getConferences" 
                    :key="conference" :value="conference.id">{{conference.conferenceYear}}</option>
                </select>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="date" v-model="formData.date" 
                    placeholder="Speaker full date" id="date">
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                    <select v-model="formData.label" id="label" 
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="conference" disabled>Choose Label</option>
                    <option v-for="singleDay in Daylabels" 
                    :key="singleDay.tag" :value="singleDay.value">{{singleDay.tag}}</option>
                </select>
                </div>
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="conference" class="block text-sm font-medium text-gray-700">Select Status</label>
                <select v-model="formData.status" id="conference" 
                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="conference" disabled>Choose Status</option>
                    <option v-for="singleDay in statusList" 
                    :key="singleDay.tag" :value="singleDay.value">{{singleDay.tag}}</option>
                </select>
            </div>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i></button>
          <button @click="scheduleStore.toogleDayDialog('close')" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
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