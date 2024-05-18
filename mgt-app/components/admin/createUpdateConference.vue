<script  setup>
const props = defineProps({
    passedItem:{
        type:String,
        default: null
    },
    eventAction: {
        type: String,
        default: 'create'
    },
    showStatus:{
        type: Boolean,
        default: false
    }
})

const year = ref(new Date().getFullYear());
const eventStore = useEventStore()
const formData = ref({defaultFee:400000, guestFee:400000,foreignerFee: 300,
  conferenceYear:year.value,
  startDate: `${year.value}-10-10`,
  endDate: `${year.value}-10-15`,
})
const setDates = ()=> {
  formData.value.startDate = `${formData.value.conferenceYear}-10-10`
  formData.value.endDate =`${formData.value.conferenceYear}-10-15`
}
const globalStore = useGlobalDataStore()
const handleForm = async ()=> {
    globalStore.toggleLoadingState('on')
    if(props.eventAction === 'update'){
        formData.value.id = props.passedItem
    }
    formData.value.action = props.eventAction
    const {data, error}  = await eventStore.createUpdateEvent(formData.value)
    console.log(error.value)
}
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{'hide': !props.showStatus}" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-white w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.eventAction}} Conference Configuration</h2>
        <form @submit.prevent="handleForm()">
            <pre>{{ props.passedItem }}</pre>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="Theme" class="block text-sm font-medium text-gray-700">Theme</label>
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="text" v-model="formData.theme" placeholder="Add a Conference Theme" id="Theme">
            </div>
        <div class="flex justify-evenly ">
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="StartDate" class="block text-sm font-medium text-gray-700">Select Year</label>
                <select v-model="formData.conferenceYear" @change="setDates()" id="" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="year" disabled>Choose Year</option>
                    <option v-for="year in eventStore.getYearsArray" :key="year" :value="year">{{year}}</option>
                </select>
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="StartDate" class="block text-sm font-medium text-gray-700">Commence Date</label>
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="date" v-model="formData.startDate" placeholder="Commence date" id="StartDate">
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="endDate" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="date" v-model="formData.endDate" placeholder="Due date" id="endDate">
            </div>
        </div>
        <div class="flex justify-evenly ">
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="conferenceFee" class="block text-sm font-medium text-gray-700">Default Fee</label>
                <input v-model="formData.defaultFee" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="number"  placeholder="Amount Tsh" id="conferenceFee">
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="guestFee" class="block text-sm font-medium text-gray-700">Guest Fee</label>
                <input v-model="formData.guestFee" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="number" placeholder="Amount in Tsh" id="guestFee">
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="foreignFee" class="block text-sm font-medium text-gray-700">Foreigner Fee</label>
                <input v-model="formData.foreignerFee" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                type="number" placeholder="Amount in $" id="foreignFee">
            </div>
        </div>
        <div class="mb-4 border-b-2 border-teal-500 py-2">
            <label for="conferenceVenue" class="block text-sm font-medium text-gray-700">Conference Venue</label>
            <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
            type="text" v-model="formData.venue" placeholder="Add a Conference Venue" id="conferenceVenue">
        </div>
        <div class="mb-4 border-b-2 border-teal-500 py-2">
            <label for="AboutConference" class="block text-sm font-medium text-gray-700">About Conference</label>
            <textarea v-model="formData.aboutConference" id="AboutConference" cols="3" rows="4" 
            placeholder="Write something about the Conference"
            class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
            </textarea>
        </div>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i></button>
          <button @click="eventStore.toggleEventModal()" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
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